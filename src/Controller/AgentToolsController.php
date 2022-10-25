<?php

namespace App\Controller;

use App\Entity\Deposit;
use App\Entity\Payment;
use App\Entity\SenderReceiver;
use App\Repository\AgentRepository;
use App\Repository\CountryRepository;
use App\Repository\PaymentRepository;
use App\Repository\SourcefundsRepository;
use App\Repository\SourcepurposeRepository;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/agent789pmyazed")
 *  @IsGranted("ROLE_AGENT")
 */
class AgentToolsController extends AbstractController
{
    private $logger;
    private $dataTableFactory;
    private $countryRepository;
    private $sourcefundRepository;
    private $sourcepurposeRepository;
    private $agentRepository;
    private $paymentRepository;

    /**
     * ManagerAgentController constructor.
     * @param AgentRepository $agentRepository
     * @param SourcefundsRepository $sourcefundRepository
     * @param SourcepurposeRepository $sourcepurposeRepository
     * @param CountryRepository $countryRepository
     * @param LoggerInterface $logger
     * @param DataTableFactory $dataTableFactory
     */
    public function __construct(PaymentRepository $paymentRepository,AgentRepository $agentRepository,SourcefundsRepository $sourcefundRepository,SourcepurposeRepository $sourcepurposeRepository,CountryRepository $countryRepository,LoggerInterface $logger, DataTableFactory $dataTableFactory)
    {
        $this->logger = $logger;
        $this->dataTableFactory = $dataTableFactory;
        $this->countryRepository=$countryRepository;
        $this->sourcefundRepository=$sourcefundRepository;
        $this->sourcepurposeRepository=$sourcepurposeRepository;
        $this->agentRepository=$agentRepository;
        $this->paymentRepository=$paymentRepository;
    }
    /**
     * @Route("/transaction/", name="app_agent_transaction_history")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('agent_tools/index.html.twig', [

        ]);
    }
    /**
     * @Route("/payouthistory", name="app_agent_payout_history")
     * @return Response
     */
    public function payouthistory(Request $request): Response
    {
        $user=$this->getUser();
        $table = $this->dataTableFactory->create()
            ->add('createdAt', TextColumn::class, [
                'label'=>"Created"
            ])
            ->add('reference', TextColumn::class, [
                'label'=>"N° transaction"
            ])
            ->add('amount', TextColumn::class, [
                'label'=>"Amount"
            ])

            ->add('status', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'status',
                'render' => function ($value, $context) {
                    if ($value) {
                        return '<a class="btn btn-sm btn-success">Enable</a>';
                    }else {
                        return '<a class="btn btn-sm btn-warning">Disabled</a>';
                    }
                }])
            ->add('id', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'render' => function ($value, $context) {
                    $url = $this->generateUrl('app_agent_transaction_detail', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-desktop"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) use($user) {
                    $builder
                        ->select('payment')
                        ->from(Deposit::class, 'payment')
                        ->andWhere('payment.createdby = :createdby')
                        ->setParameter('createdby',$user);
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('agent_tools/payout_history.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("/payoutadd", name="app_agent_payout_add")
     * @return Response
     */
    public function payoutadd(): Response
    {
        return $this->render('agent_tools/payout_add.html.twig', [

        ]);
    }
    /**
     * @Route("/sendhistory", name="app_agent_send_history")
     * @return Response
     */
    public function sendthistory(Request $request): Response
    {
        $user=$this->getUser();
        $table = $this->dataTableFactory->create()
            ->add('reference', TextColumn::class, [
                'label'=>"N° transaction"
            ])
            ->add('amount', TextColumn::class, [
                'label'=>"Sending Amount"
            ])
            ->add('amountreceive', TextColumn::class, [
                'label'=>"Receiver Amount"
            ])
            ->add('status', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'status',
                'render' => function ($value, $context) {
                    if ($value) {
                        return '<a class="btn btn-sm btn-success">Enable</a>';
                    }else {
                        return '<a class="btn btn-sm btn-warning">Disabled</a>';
                    }
                }])
            ->add('id', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'render' => function ($value, $context) {
                    $url = $this->generateUrl('app_agent_transaction_detail', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-desktop"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) use($user) {
                    $builder
                        ->select('payment')
                        ->from(Payment::class, 'payment')
                    ->andWhere('payment.createdby = :createdby')
                    ->setParameter('createdby',$user);
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('agent_tools/send_history.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("/sendmoney", name="app_agent_send_money")
     * @return Response
     */
    public function sendmoney(): Response
    {
        return $this->render('agent_tools/send_money.html.twig', [
            'countries'=>$this->countryRepository->findAll(),
            'sourcefunds'=>$this->sourcefundRepository->findBy(['status'=>true]),
            'sourcepurposes'=>$this->sourcepurposeRepository->findBy(['status'=>true])
        ]);
    }
    /**
     * @Route("/depositadddeposit", name="app_agent_deposit_add")
     * @return Response
     */
    public function depositadd(): Response
    {
        return $this->render('agent_tools/depositadd.html.twig', [

        ]);
    }
    /**
     * @Route("/depositlist", name="app_agent_deposit_lis")
     * @return Response
     */
    public function depositlist(Request $request): Response
    {
        $user=$this->getUser();
        $table = $this->dataTableFactory->create()
            ->add('createdAt', TextColumn::class, [
                'label'=>"Created"
            ])
            ->add('reference', TextColumn::class, [
                'label'=>"N° transaction"
            ])
            ->add('amount', TextColumn::class, [
                'label'=>"Amount"
            ])

            ->add('status', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'status',
                'render' => function ($value, $context) {
                    if ($value) {
                        return '<a class="btn btn-sm btn-success">Enable</a>';
                    }else {
                        return '<a class="btn btn-sm btn-warning">Disabled</a>';
                    }
                }])
            ->add('id', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'render' => function ($value, $context) {
                    $url = $this->generateUrl('app_agent_transaction_detail', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-desktop"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) use($user) {
                    $builder
                        ->select('payment')
                        ->from(Deposit::class, 'payment')
                        ->andWhere('payment.createdby = :createdby')
                        ->setParameter('createdby',$user);
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('agent_tools/depositlist.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("transactiondetail/{id}", name="app_agent_transaction_detail", methods={"GET","POST"},options={"expose"=true})
     */
    public function edit(Request $request, Payment $payment): Response
    {
        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('app_agent_send_history');
        }

        return $this->render('agent_tools/transactiondetail.html.twig', [
            'transaction' => $payment,
            'id' => $payment->getId()
        ]);
    }
    /**
     * @Route("/get_value_currency_ajax", name="get_value_currency", methods={"GET","POST"})
     */
    public function get_value_currency(Request $request): JsonResponse
    {
        $from = $this->countryRepository->find($request->get('id_from'));
        $to= $this->countryRepository->find($request->get('id_to'));
        $amount_from=empty($request->get('amount_from'))?0:$request->get('amount_from');
        $from_val_usd=round($to->getRate()/$from->getRate(),2);
        $amount_to=$amount_from*$from_val_usd;
        $charge=$amount_to==0?0.0:round(($to->getFixedcharged()+($to->getPercentcharge()*0.01*$amount_to))/$from_val_usd,2);
        $final_amount=$amount_from+$charge;
        return new JsonResponse([
            'value' => $from_val_usd,
            'amount_to'=>$amount_to,
            'charge'=>$charge,
            'finalamount'=>round($final_amount,2),
            'payable_usd'=>round($final_amount/$from->getRate(),2)
        ], "200");
    }
    /**
     * @Route("/get_value_currency_to_ajax", name="get_value_to_currency", methods={"GET","POST"})
     */
    public function get_value_to_currency(Request $request): JsonResponse
    {
        $from = $this->countryRepository->find($request->get('id_from'));
        $to= $this->countryRepository->find($request->get('id_to'));
        $amount_to=is_null($request->get('amount_to'))?0.0:$request->get('amount_to');
        $from_val_usd=round($to->getRate()/$from->getRate(),2);
        $amount_from=$amount_to/$from_val_usd;
        $charge=$amount_to==0?0.0:round(($to->getFixedcharged()+($to->getPercentcharge()*0.01*$amount_to))/$from_val_usd,2);
        $final_amount=$amount_from+$charge;
        return new JsonResponse([
            'value' => $from_val_usd,
            'amount_from'=>$amount_from,
            'charge'=>$charge,
            'finalamount'=>round($final_amount,2),
            'payable_usd'=>round($final_amount/$from->getRate(),2)
        ], "200");
    }
    /**
     * @Route("/sendmoney_ajax", name="sendmoney_ajax", methods={"GET","POST"})
     */
    public function sendMoneyajax(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $from = $this->countryRepository->find($request->get('id_from'));
        $to= $this->countryRepository->find($request->get('id_to'));
        $amount_to=$request->get('amount_to');
        $amount_from=$request->get('amount_from');
        $charge=$request->get('charge');
        $sender=new SenderReceiver();
        $sender->setAddress($request->get('sender_address'));
        $sender->setPhone($request->get('sender_phone'));
        $sender->setName($request->get('sender_name'));
        $entityManager->persist($sender);
        $receiver=new SenderReceiver();
        $receiver->setAddress($request->get('receiver_address'));
        $receiver->setPhone($request->get('receiver_phone'));
        $receiver->setName($request->get('receiver_name'));
        $entityManager->persist($receiver);
        $source_puporse=$this->sourcepurposeRepository->find($request->get('send_puporse'));
        $source_found=$this->sourcefundRepository->find($request->get('source_fund'));

        $transaction=new Payment();
        $transaction->setReference($this->generatereference());
        $transaction->setCountryfrom($from);
        $transaction->setCountry($to);
        $transaction->setAmount($amount_from);
        $transaction->setAmountreceive($amount_to);
        $transaction->setRate($charge);
        $transaction->setSender($sender);
        $transaction->setReceiver($receiver);
        $transaction->setCreatedby($this->getUser());
        $transaction->setSourcefund($source_found);
        $transaction->setSourcepurpose($source_puporse);
        $transaction->setStatus(Payment::PAID);

        $entityManager->persist($transaction);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $transaction->getId()
        ], "200");
    }
   private function generatereference(){
        $numero = $this->generateNumero();
        $date = new \DateTime('now');
        $month = $date->format('m');
        $year = $date->format('Y');
        $day = $date->format('d');
        $text = "RMT" . $day . $month . $year . $numero;
        return $text;
    }
    private function generateNumero()
    {
        $last = null;
        if (null == $this->paymentRepository->findOneByLast()) {
            $last = 0;
        } else {
            $last = $this->paymentRepository->findOneByLast()->getId();
        }
        $transaction_numero = '';
        $allowed_characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
        for ($i = 1; $i <= 8; $i++) {
            $transaction_numero .= $allowed_characters[rand(0, count($allowed_characters) - 1)];
        }

        $txt = $transaction_numero . ($last + 1);
        return str_pad($txt, 4, 0, STR_PAD_LEFT);
    }
}
