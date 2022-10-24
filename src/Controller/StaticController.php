<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Payment;
use App\Entity\Sourcefunds;
use App\Entity\Sourcepurpose;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin1gre417az87")
 *  @IsGranted("ROLE_ADMIN")
 */
class StaticController extends AbstractController
{
    private $logger;
    private $dataTableFactory;

    /**
     * ManagerAgentController constructor.
     * @param $logger
     * @param $dataTableFactory
     */
    public function __construct(LoggerInterface $logger, DataTableFactory $dataTableFactory)
    {
        $this->logger = $logger;
        $this->dataTableFactory = $dataTableFactory;
    }
    /**
     * @Route("countries", name="app_static_country", methods={"GET","POST"})
     * @return Response
     */
    public function index(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('country', TextColumn::class, [
                'field' => 'country.name'
            ])
            ->add('flag', TextColumn::class, [
                'field' => 'country.flag'
            ])
            ->add('currency', TextColumn::class, [
                'field' => 'country.currency'
            ])
            ->add('rate', TextColumn::class, [
                'field' => 'country.rate'
            ])
            ->add('fixedcharged', TextColumn::class)
            ->add('percentcharge', TextColumn::class)
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Country::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('country')
                        ->from(Country::class, 'country');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/index.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("sourcepurpose", name="app_static_sourcepurpose", methods={"GET","POST"})
     * @return Response
     */
    public function sourcepurpose(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_puporse_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Sourcepurpose::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('sourcepurpose')
                        ->from(Sourcepurpose::class, 'sourcepurpose');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sourcepurpose.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("sourcefounds", name="app_static_sourcefounds", methods={"GET","POST"})
     * @return Response
     */
    public function sourcefounds(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_founds_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Country::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('sourcefunds')
                        ->from(Sourcefunds::class, 'sourcefunds');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sourcefounds.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("send_al", name="app_static_sendall", methods={"GET","POST"})
     * @return Response
     */
    public function sendall(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('p')
                        ->from(Payment::class, 'p');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sendall.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("sendpaid", name="app_static_sendpaid")
     * @return Response
     */
    public function sendpaid(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('payment')
                        ->from(Payment::class, 'payment')
                        ->andWhere('payment.status = :status')
                        ->setParameter('status',Payment::PAID);
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sendpaid.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("sendrefunded", name="app_static_sendrefunded", methods={"GET","POST"})
     * @return Response
     */
    public function sendrefunded(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('payment')
                        ->from(Payment::class, 'payment')
                        ->andWhere('payment.status = :status')
                        ->setParameter('status',Payment::REFUNDED);
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sendrefunded.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("sendpayout", name="app_static_sendpayout", methods={"GET","POST"})
     * @return Response
     */
    public function sendpayout(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Sourcepurpose::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('sourcefunds')
                        ->from(Sourcepurpose::class, 'sourcefunds');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sendpayout.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("sendrejet", name="app_static_sendrejet", methods={"GET","POST"})
     * @return Response
     */
    public function sendrejet(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Payment::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('payment')
                        ->from(Payment::class, 'payment')
                         ->andWhere('payment.status = :status')
                        ->setParameter('status',Payment::REJECT);
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/sendrejet.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("gatewayautomatic", name="app_static_gatewayautomatic", methods={"GET","POST"})
     * @return Response
     */
    public function gatewayautomatic(Request $request): Response
    {
        return $this->render('static/gatewayautomatic.html.twig', [

        ]);
    }
    /**
     * @Route("gatewaymanuel", name="app_static_gatewaymanuel", methods={"GET","POST"})
     * @return Response
     */
    public function gatewaymanuel(Request $request): Response
    {
        return $this->render('static/gatewaymanuel.html.twig', [

        ]);
    }
    /**
     * @Route("depositpending", name="app_static_depositpending", methods={"GET","POST"})
     * @return Response
     */
    public function depositpending(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Sourcepurpose::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('sourcefunds')
                        ->from(Sourcepurpose::class, 'sourcefunds');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/depositpending.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("depositsucces", name="app_static_depositsucces", methods={"GET","POST"})
     * @return Response
     */
    public function depositsucces(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Sourcepurpose::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('sourcefunds')
                        ->from(Sourcepurpose::class, 'sourcefunds');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/depositsucces.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("depositreject", name="app_static_depositreject", methods={"GET","POST"})
     * @return Response
     */
    public function depositreject(Request $request): Response
    {
        $table = $this->dataTableFactory->create()
            ->add('name', TextColumn::class, [
                'field' => 'country.name'
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
                    $url = $this->generateUrl('app_static_country_edit', ['id' => $context->getId()]);
                    return '<a class="btn btn-sm btn-success"  href='.$url.'><i class="fa fa-edit"></i></a>';
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Sourcepurpose::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('sourcefunds')
                        ->from(Sourcepurpose::class, 'sourcefunds');
                },
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('static/depositreject.html.twig', [
            'datatable' => $table
        ]);
    }
    /**
     * @Route("country/new", name="app_static_country_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newcountry(Request $request): Response
    {  $entityManager = $this->getDoctrine()->getManager();

        if ($request->getMethod() === 'POST') {
            dump($request);
            $country = new Country();
            $country->setName($request->get('name'));
            $country->setFlag($request->get('flag'));
            $country->setCurrency($request->get('currency'));
            $country->setFixedcharged($request->get('fixedcharge'));
            $country->setRate($request->get('rate'));
            $country->setPercentcharge($request->get('percentcharge'));
            $imageFilename = $request->get('flagg');
           /* if ($imageFilename) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($imageFilename->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFilename->guessExtension();

                try {
                    $imageFilename->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $country->setFlag($newFilename);
            }*/


            $entityManager->persist($country);
            $entityManager->flush();
            return $this->redirectToRoute('app_static_country');
        }
        return $this->redirectToRoute('app_static_country');
    }
    /**
     * @Route("countryedit/{id}", name="app_static_country_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Country $country): Response
    {
        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $country->setName($request->get('name'));
            $country->setFlag($request->get('flag'));
            $country->setCurrency($request->get('currency'));
            $country->setFixedcharged($request->get('fixedcharge'));
            $country->setRate($request->get('rate'));
            $country->setPercentcharge($request->get('percentcharge'));
            $entityManager->flush();
            return $this->redirectToRoute('app_static_country');
        }

        return $this->render('static/editcountry.html.twig', [
            'country' => $country
        ]);
    }
    /**
     * @Route("sourcefound/new", name="app_static_source_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newsourcefounds(Request $request): Response
    {  $entityManager = $this->getDoctrine()->getManager();

        if ($request->getMethod() === 'POST') {
            $source = new Sourcefunds();
            $source->setName($request->get('name'));
            $source->setStatus(true);
            $entityManager->persist($source);
            $entityManager->flush();
            return $this->redirectToRoute('app_static_sourcefounds');
        }
        return $this->redirectToRoute('app_static_sourcefounds');
    }
    /**
     * @Route("sourcefoundsedit/{id}", name="app_static_founds_edit", methods={"GET","POST"})
     */
    public function editsource(Request $request, Sourcefunds $sourcefunds): Response
    {
        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $sourcefunds->setName($request->get('name'));

            $sourcefunds->setStatus($request->get('status'));
            $entityManager->flush();
            return $this->redirectToRoute('app_static_sourcefounds');
        }

        return $this->render('static/editsourcefunds.html.twig', [
            'sourcefunds' => $sourcefunds
        ]);
    }
    /**
     * @Route("sourcepurpose/new", name="app_static_purpose_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newsourcepurpose(Request $request): Response
    {  $entityManager = $this->getDoctrine()->getManager();

        if ($request->getMethod() === 'POST') {
            $source = new Sourcepurpose();
            $source->setName($request->get('name'));
            $source->setStatus(true);
            $entityManager->persist($source);
            $entityManager->flush();
            return $this->redirectToRoute('app_static_sourcepurpose');
        }
        return $this->redirectToRoute('app_static_sourcepurpose');
    }
    /**
     * @Route("sourcepurposesedit/{id}", name="app_static_puporse_edit", methods={"GET","POST"})
     */
    public function editpuporse(Request $request, Sourcepurpose $sourcepurpose): Response
    {
        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $sourcepurpose->setName($request->get('name'));

            $sourcepurpose->setStatus($request->get('status'));
            $entityManager->flush();
            return $this->redirectToRoute('app_static_sourcefounds');
        }

        return $this->render('static/editsourcepurpose.html.twig', [
            'sourcepurpose' => $sourcepurpose
        ]);
    }
}
