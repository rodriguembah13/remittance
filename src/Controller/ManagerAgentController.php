<?php

namespace App\Controller;

use App\Entity\AgentUser;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
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
class ManagerAgentController extends AbstractController
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
     * @Route("agent/all", name="app_manager_agent_all")
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
                        ->select('agent_user', 'compte')
                        ->from(AgentUser::class, 'agent_user')
                        ->leftJoin('agent_user.compte', 'compte');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('manager_agent/index.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("agent/banned", name="app_manager_agent_banned")
     * @param Request $request
     * @return Response
     */
    public function bannedagent(Request $request): Response
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
                        ->select('agent_user', 'compte')
                        ->from(AgentUser::class, 'agent_user')
                        ->andWhere('agent_user.status = :status')
                        ->setParameter('status',AgentUser::BANNED)
                        ->leftJoin('agent_user.compte', 'compte');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('manager_agent/bannedagent.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("agent/active", name="app_manager_agent_active")
     * @param Request $request
     * @return Response
     */
    public function activeagent(Request $request): Response
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
                        ->select('agent_user', 'compte')
                        ->from(AgentUser::class, 'agent_user')
                        ->andWhere('agent_user.status = :status')
                        ->setParameter('status',AgentUser::ACTIVE)
                        ->leftJoin('agent_user.compte', 'compte');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('manager_agent/activeagent.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("agent/new", name="app_manager_agent_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            $user = new User();
            $user->setName($request->get('name'));
            $user->setRoles(["ROLE_AGENT"]);
            $user->setPhone($request->get('phone'));
            $user->setEmail($request->get('email'));
            $agent = new AgentUser();
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
            return $this->redirectToRoute('app_manager_agent_all');
        }

        return $this->render('manager_agent/new.html.twig', [

        ]);
    }

    /**
     * @Route("agent/edit/{id}", name="app_manager_agent_edit", methods={"GET","POST"})
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
            return $this->redirectToRoute('app_manager_agent_all');
        }

        return $this->render('manager_agent/edit.html.twig', [
            'agent' => $agentUser

        ]);
    }
}
