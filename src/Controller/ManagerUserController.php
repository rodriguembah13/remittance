<?php

namespace App\Controller;

use App\Entity\AgentUser;
use App\Entity\Customer;
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
}
