<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Payment;
use App\Entity\SenderReceiver;
use App\Entity\User;
use App\Repository\ConfigurationRepository;
use App\Repository\CountryRepository;
use App\Repository\CustomerRepository;
use App\Repository\PaymentRepository;
use App\Repository\SenderReceiverRepository;
use App\Repository\SourcefundsRepository;
use App\Repository\SourcepurposeRepository;
use App\Service\EndpointService;
use App\Service\paiement\TransferzeroService;
use Omines\DataTablesBundle\DataTableFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private $params;
    private $dataTableFactory;
    private $endpointService;
    private $customerRepository;
    private $configurationRepository;
    private $countryRepository;
    private $logger;
    private $transfertzeroService;
    private $paiementRepository;
    private $sourcefundRepository;
    private $sourcepurposeRepository;
    private $senderReceiverRepository;
    private $passwordEncoder;
    /**
     * @param CustomerRepository $customerRepository
     * @param LoggerInterface $logger
     * @param EndpointService $endpointService
     * @param DataTableFactory $dataTableFactory
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(UserPasswordHasherInterface $passwordEncoder,CustomerRepository $customerRepository,ConfigurationRepository $configurationRepository,
                                CountryRepository $countryRepository,TransferzeroService $transferzeroService,
                                SourcefundsRepository $sourcefundRepository,SenderReceiverRepository $senderReceiverRepository,
                                SourcepurposeRepository $sourcepurposeRepository,
                                LoggerInterface $logger,EndpointService $endpointService,PaymentRepository $paymentRepository,
                                DataTableFactory $dataTableFactory,ParameterBagInterface $parameterBag)
    {
        $this->params = $parameterBag;
        $this->dataTableFactory = $dataTableFactory;
        $this->endpointService=$endpointService;
        $this->logger=$logger;
        $this->customerRepository=$customerRepository;
        $this->countryRepository=$countryRepository;
        $this->configurationRepository=$configurationRepository;
        $this->transfertzeroService=$transferzeroService;
        $this->paiementRepository=$paymentRepository;
        $this->sourcefundRepository=$sourcefundRepository;
        $this->sourcepurposeRepository=$sourcepurposeRepository;
        $this->senderReceiverRepository=$senderReceiverRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()){
            if ($this->getUser()->getRoles()[0]==="ROLE_ADMIN"){
                return $this->redirectToRoute('homeadmin');
            }else if ($this->getUser()->getRoles()[0]==="ROLE_AGENT"){
                return $this->redirectToRoute('homeagent');
            }else{
                return $this->redirectToRoute('homeuser');
            }
        }else{
            return $this->redirectToRoute('homeuser');
        }

    }
    /**
     * @Route("/admin1gre417az87/", name="homeadmin")
     * @param Request $request
     * @return Response
     */
    public function homeadmin(Request $request): Response
    {
        return $this->render('default/homeadmin.html.twig', [

        ]);
    }
    /**
     * @Route("/agent789pmyazed/", name="homeagent")
     * @param Request $request
     * @return Response
     */
    public function homeagent(Request $request): Response
    {
        return $this->render('default/homeagent.html.twig', [

        ]);
    }
    /**
     * @Route("/home", name="homeuser")
     * @param Request $request
     * @return Response
     */
    public function homeuser(Request $request): Response
    {
        return $this->render('default/homeuser.html.twig', [
            'configuration'=>$this->configurationRepository->findOneByLast(),
            'countries'=>$this->countryRepository->findAll(),
        ]);
    }
    /**
     * @Route("/notifyurlflutter/ajax", name="notifyurlflutterajax", methods={"POST","GET"})
     */
    public function notifyurlflutter(Request $request)
    {
        $this->logger->error("----------------------- notify call");
        $data=json_decode($request->getContent(), true);
        $this->logger->error("----------------------- notify call". $request->get('customer'));
        if (!empty($request->get('status'))) {
            $status = $request->get('status');
            $customer_ = $this->customerRepository->find($request->get('customer'));
            $souscription_ = $this->souscriptionRepository->findOneBy(['reference'=>$request->get('ref')]);
            if ($souscription_->getStatus() == "PENDING") {
                if ($status == "successful") {
                 //   $this->updateVote($vote_, 'ACCEPTED');
                } elseif ($status == "cancelled") {
                  //  $this->updateVote($vote_, 'REFUSED');
                }
            }
        }else{
            $status = $request->get('status');
        }
        return $this->redirectToRoute('home');
    }
    /**
     * @Route("/customersendmoney_ajax", name="customer_sendmoney_ajax", methods={"GET","POST"})
     */
    public function sendMoneyajax(Request $request): JsonResponse
    {
        $this->logger->info('{user} is connect');
        $entityManager = $this->getDoctrine()->getManager();
        $from = $this->countryRepository->find($request->get('id_from'));
        $to= $this->countryRepository->find($request->get('id_to'));
        $amount_to=$request->get('amount_to');
        $amount_from=$request->get('amount_from');
        $charge=$request->get('charge');
        $payable=$request->get('payable');
        $receiver=$this->senderReceiverRepository->findOneBy(['name'=>$request->get('receiver_name'),'phone'=>$request->get('receiver_phone')]);
        if (is_null($receiver)){
            $receiver=new SenderReceiver();
            $receiver->setAddress($request->get('receiver_address'));
            $receiver->setPhone($request->get('receiver_phone'));
            $receiver->setName($request->get('receiver_name'));
            $entityManager->persist($receiver);
        }
        $user=$this->getUser();
        $sender=$this->senderReceiverRepository->findOneBy(['name'=>$user->getName(),'phone'=>$user->getPhone()]);
        if (is_null($sender)){
            $sender=new SenderReceiver();
            $sender->setName($user->getName());
            $sender->setPhone($user->getPhone());
            $sender->setPhone($user->getAddress());
            $sender->setCreatedAt(new \DateTime('now'));
            $entityManager->persist($sender);
        }
        $source_puporse=$this->sourcepurposeRepository->find($request->get('send_puporse'));
        $source_found=$this->sourcefundRepository->find($request->get('source_fund'));
        $customer=$this->customerRepository->findOneBy(['compte'=>$user]);
        if (is_null($customer)){
            $customer=new Customer();
            $customer->setCompte($user);
            $entityManager->persist($customer);
        }
        $transaction=new Payment();
        $transaction->setReference($this->generatereference());
        $transaction->setCountryfrom($from);
        $transaction->setCountry($to);
        $transaction->setAmount($amount_from);
        $transaction->setAmountreceive($amount_to);
        $transaction->setRate($charge);
        $transaction->setSender($sender);
        $transaction->setReceiver($receiver);
        $transaction->setCreatedby($user);
        $transaction->setSourcefund($source_found);
        $transaction->setSourcepurpose($source_puporse);
        $transaction->setStatus(Payment::PENDING);
        $data=[
            'sender_firstname'=>$customer->getCompte()->getName(),
            'sender_lastname'=>$customer->getCompte()->getName(),
            'sender_countrycode'=>$from->getFlag(),
            'sender_phone'=>$customer->getCompte()->getPhone(),
            'sender_city'=>is_null($customer->getCompte()->getAddress())?"DOHA":$customer->getCompte()->getAddress(),
            'sender_street'=>"your-street",
            'sender_codepostal'=>is_null($customer->getCompte()->getPostal())?'70007':$customer->getCompte()->getPostal(),
            'sender_birthdate'=>"1988-12-12",
            'sender_currency'=>$from->getCurrency(),
            'receiver_currency'=>$to->getCurrency(),
            'reference'=>$transaction->getReference(),
            'receiver_phone'=>$receiver->getPhone(),
            'receiver_name'=>$receiver->getName(),
            'receiver_amount'=>$payable,
            'payout_type'=>$request->get('method_payment'),
            'receiver_mobile_provider'=>"orange",
            'receiver_country'=>$to->getFlag(),
            'method_payment'=>$request->get('method_payment'),
            'method_type'=>$request->get('method_type'),
            'method_uxflow'=>"ussd_voucher",
            'receiver_bankaccount'=>$request->get('bank_account'),
            'receiver_bankcode'=>$request->get('bank_code'),
            'receiver_banktype'=>$request->get('bank_account_type'),
            'receiver_bankiban'=>$request->get('bank_iban'),
        ];
        if ($data['method_type']==="bank"){
            $response=$this->transfertzeroService->postcollectionOut($data);
        }else{
            $response=$this->transfertzeroService->postcollection($data);
        }

        $entityManager->persist($transaction);
        $entityManager->flush();
        return new JsonResponse([
           $response
        ], "200");
    }
    /**
     * @Route("/get_customer_value_currency_ajax", name="get_customer_value_currency", methods={"GET","POST"})
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
     * @Route("/get_value_customer_currency_to_ajax", name="get_customer_value_to_currency", methods={"GET","POST"})
     */
    public function get_customer_value_to_currency(Request $request): JsonResponse
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
     * @Route("/dashboard", name="dashboarduser")
     * @param Request $request
     * @return Response
     */
    public function dashboarduser(Request $request): Response
    {
        return $this->render('default/dashboarduser.html.twig', [
            'configuration'=>$this->configurationRepository->findOneByLast(),
            'countries'=>$this->countryRepository->findAll(),
        ]);
    }
    /**
     * @Route("/history", name="historyuser",options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function historySendin(Request $request): Response
    {
        return $this->render('default/historyuser.html.twig', [
            'transactions'=>$this->paiementRepository->findBy(['createdby'=>$this->getUser()]),
            'configuration'=>$this->configurationRepository->findOneByLast(),
            'countries'=>$this->countryRepository->findAll(),
        ]);
    }
    /**
     * @Route("/sendmoney", name="customer_sendmoney")
     * @param Request $request
     * @return Response
     */
    public function sendmoney(Request $request): Response
    {
        return $this->render('default/sendmoney.html.twig', [
            'configuration'=>$this->configurationRepository->findOneByLast(),
            'countries'=>$this->countryRepository->findAll(),
            'sourcefunds'=>$this->sourcefundRepository->findBy(['status'=>true]),
            'sourcepurposes'=>$this->sourcepurposeRepository->findBy(['status'=>true])
        ]);
    }
    /**
     * @Route("/profil", name="profil")
     * @param Request $request
     * @return Response
     */
    public function profil(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $customer=$this->customerRepository->findOneBy(['compte'=>$user]);
        if ($request->getMethod()=="POST"){
            $customer->setCountry($request->get('country'));
           $compte=$customer->getCompte();
           $compte->setPhone($request->get('phone'));
            $compte->setName($request->get('name'));
            $compte->setAddress($request->get('address'));
            $compte->setCity($request->get('city'));
            $compte->setPostal($request->get('postal'));
            $entityManager->flush();
        }
        return $this->render('default/profil.html.twig', [
            'configuration'=>$this->configurationRepository->findOneByLast(),
            'countries'=>$this->countryRepository->findAll(),
            'customer'=>$customer,
        ]);
    }
    /**
     * @Route("/changepassword", name="changepassword")
     * @param Request $request
     * @return Response
     */
    public function changepassword(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $customer=$this->customerRepository->findOneBy(['compte'=>$user]);
        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('logincustomer');
        }
        if ($request->getMethod()=="POST"){
            // On supprime le token

            // On chiffre le mot de passe
            $user->setPassword($this->passwordEncoder->hashPassword($customer->getCompte(), $request->request->get('newpassword')));

            // On stocke
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // On crée le message flash
            $this->addFlash('message', 'Mot de passe mis à jour');

            // On redirige vers la page de connexion
            return $this->redirectToRoute('logincustomer');
        }
        return $this->render('default/changepassword.html.twig', [
            'configuration'=>$this->configurationRepository->findOneByLast(),
            'countries'=>$this->countryRepository->findAll(),
        ]);
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
        if (null == $this->paiementRepository->findOneByLast()) {
            $last = 0;
        } else {
            $last = $this->paiementRepository->findOneByLast()->getId();
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
