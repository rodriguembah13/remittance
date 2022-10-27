<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Payment;
use App\Entity\SenderReceiver;
use App\Repository\ConfigurationRepository;
use App\Repository\CountryRepository;
use App\Repository\CustomerRepository;
use App\Service\EndpointService;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @param CustomerRepository $customerRepository
     * @param LoggerInterface $logger
     * @param EndpointService $endpointService
     * @param DataTableFactory $dataTableFactory
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(CustomerRepository $customerRepository,ConfigurationRepository $configurationRepository,
                                CountryRepository $countryRepository,
                                LoggerInterface $logger,EndpointService $endpointService,
                                DataTableFactory $dataTableFactory,ParameterBagInterface $parameterBag)
    {
        $this->params = $parameterBag;
        $this->dataTableFactory = $dataTableFactory;
        $this->endpointService=$endpointService;
        $this->logger=$logger;
        $this->customerRepository=$customerRepository;
        $this->countryRepository=$countryRepository;
        $this->configurationRepository=$configurationRepository;
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
        $entityManager = $this->getDoctrine()->getManager();
        $from = $this->countryRepository->find($request->get('id_from'));
        $to= $this->countryRepository->find($request->get('id_to'));
        $amount_to=$request->get('amount_to');
        $amount_from=$request->get('amount_from');
        $charge=$request->get('charge');


        return new JsonResponse([
            []
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
}
