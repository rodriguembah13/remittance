<?php

namespace App\Controller;

use App\Entity\AgentUser;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin1gre417az87")
 *  @IsGranted("ROLE_ADMIN")
 */
class ManagerUserController extends AbstractController
{
    private $logger;
    private $dataTableFactory;
    private $passwordEncoder;

    /**
     * ManagerAgentController constructor.
     * @param $logger
     * @param $dataTableFactory
     */
    public function __construct(LoggerInterface $logger, UserPasswordHasherInterface $passwordEncoder, DataTableFactory $dataTableFactory)
    {
        $this->logger = $logger;
        $this->dataTableFactory = $dataTableFactory;
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/customeral", name="app_manager_customer_all")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'compte.name'
            ])
            ->add('phone', TextColumn::class, [
                'field' => 'compte.phone'
            ])
            ->add('email', TextColumn::class, [
                'field' => 'compte.email'
            ])
            ->add('country', TextColumn::class)
            ->add('status', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'status',
                'render' => function ($value, $context) {
                    if ($value == AgentUser::ACTIVE) {
                        return '<a class="btn btn-sm btn-success">' . $value . '</a>';
                    } elseif ($value == AgentUser::BANNED) {
                        return '<a class="btn btn-sm btn-danger">' . $value . '</a>';
                    } else {
                        return '<a class="btn btn-sm btn-warning">' . $value . '</a>';
                    }
                }])
            ->add('id', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'render' => function ($value, $context) {
                    $url = $this->generateUrl('app_manager_agent_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => AgentUser::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('customer', 'compte')
                        ->from(Customer::class, 'customer')
                        ->leftJoin('customer.compte', 'compte');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('manager_user/index.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("/customerbanne", name="app_manager_customer_banned")
     * @param Request $request
     * @return Response
     */
    public function bannedcustomer(Request $request): Response
    {

        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'compte.name'
            ])
            ->add('phone', TextColumn::class, [
                'field' => 'compte.phone'
            ])
            ->add('email', TextColumn::class, [
                'field' => 'compte.email'
            ])
            ->add('country', TextColumn::class)
            ->add('status', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'status',
                'render' => function ($value, $context) {
                    if ($value == AgentUser::ACTIVE) {
                        return '<a class="btn btn-sm btn-success">' . $value . '</a>';
                    } elseif ($value == AgentUser::BANNED) {
                        return '<a class="btn btn-sm btn-danger">' . $value . '</a>';
                    } else {
                        return '<a class="btn btn-sm btn-warning">' . $value . '</a>';
                    }
                }])
            ->add('id', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'render' => function ($value, $context) {
                    $url = $this->generateUrl('app_manager_agent_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => AgentUser::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('customer', 'compte')
                        ->from(Customer::class, 'customer')
                        ->andWhere('customer.status = :status')
                        ->setParameter('status',Customer::BANNED)
                        ->leftJoin('customer.compte', 'compte');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('manager_user/bannedcustomer.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("/customeractiv", name="app_manager_customer_active")
     * @param Request $request
     * @return Response
     */
    public function activecustomer(Request $request): Response
    {

        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'compte.name'
            ])
            ->add('phone', TextColumn::class, [
                'field' => 'compte.phone'
            ])
            ->add('email', TextColumn::class, [
                'field' => 'compte.email'
            ])
            ->add('country', TextColumn::class)
            ->add('status', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'status',
                'render' => function ($value, $context) {
                    if ($value == AgentUser::ACTIVE) {
                        return '<a class="btn btn-sm btn-success">' . $value . '</a>';
                    } elseif ($value == AgentUser::BANNED) {
                        return '<a class="btn btn-sm btn-danger">' . $value . '</a>';
                    } else {
                        return '<a class="btn btn-sm btn-warning">' . $value . '</a>';
                    }
                }])
            ->add('id', TextColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'render' => function ($value, $context) {
                    $url = $this->generateUrl('app_manager_agent_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => AgentUser::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('customer', 'compte')
                        ->from(Customer::class, 'customer')
                        ->andWhere('customer.status = :status')
                        ->setParameter('status',AgentUser::ACTIVE)
                        ->leftJoin('customer.compte', 'compte');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('manager_user/activecustomer.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("customer/new", name="app_manager_customer_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            $user = new User();
            $user->setName($request->get('name'));
            $user->setRoles(["ROLE_CUSTOMER"]);
            $user->setPhone($request->get('phone'));
            $user->setEmail($request->get('email'));
            $agent = new Customer();
            $entityManager = $this->getDoctrine()->getManager();
            $agent->setStatus(AgentUser::PENDING);
            $agent->setCountry($request->get('country'));
            $agent->setBalance(0.0);
            $agent->setKycverify(false);
            $encodedPassword = $this->passwordEncoder->hashPassword($user, $request->get('password'));
            $user->setPassword($encodedPassword);
            $entityManager->persist($user);
            $agent->setCompte($user);
            $entityManager->persist($agent);
            $entityManager->flush();
            return $this->redirectToRoute('app_manager_customer_all');
        }

        return $this->render('manager_user/new.html.twig', [

        ]);
    }

    /**
     * @Route("customer/edit/{id}", name="app_manager_customer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AgentUser $agentUser): Response
    {
        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $agentUser->getCompte();
            $user->setName($request->get('name'));
            $user->setPhone($request->get('phone'));
            $user->setEmail($request->get('email'));
            $user->setCity($request->get('city'));
            $user->setAddress($request->get('address'));
            $user->setState($request->get('state'));
            $user->setPostal($request->get('postal'));
            $agentUser->setStatus(AgentUser::PENDING);
            $agentUser->setCountry($request->get('country'));
            $agentUser->setKycverify($request->get('kyc'));
            $entityManager->flush();
            return $this->redirectToRoute('app_manager_customer_all');
        }

        return $this->render('manager_user/edit.html.twig', [
            'agent' => $agentUser

        ]);
    }
}
