<?php

namespace App\Controller;

use App\Entity\Customer;
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
    private $bouquetRepository;
    private $customerRepository;
    private $souscriptionRepository;
    private $logger;

    /**
     * @param CustomerRepository $customerRepository
     * @param LoggerInterface $logger
     * @param EndpointService $endpointService
     * @param DataTableFactory $dataTableFactory
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(CustomerRepository $customerRepository,LoggerInterface $logger,EndpointService $endpointService,DataTableFactory $dataTableFactory,ParameterBagInterface $parameterBag)
    {
        $this->params = $parameterBag;
        $this->dataTableFactory = $dataTableFactory;
        $this->endpointService=$endpointService;
        $this->logger=$logger;
        $this->customerRepository=$customerRepository;
    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()->getRoles()[0]==="ROLE_ADMIN"){
            return $this->redirectToRoute('homeadmin');
        }else{
            return $this->redirectToRoute('homeagent');
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
}
