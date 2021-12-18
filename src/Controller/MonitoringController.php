<?php

namespace App\Controller;

use App\Entity\Monitoring;
use App\Form\MonitoringType;
use App\Repository\MonitoringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/monitoring')]
class MonitoringController extends AbstractController
{
    #[Route('/', name: 'monitoring_index', methods: ['GET'])]
    public function index(MonitoringRepository $monitoringRepository): Response
    {
        return $this->render('monitoring/index.html.twig', [
            'monitorings' => $monitoringRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'monitoring_new', methods: ['GET','POST']),
    IsGranted("ROLE_ADMIN")
    ]
    public function new(Request $request): Response
    {
        $monitoring = new Monitoring();
        $form = $this->createForm(MonitoringType::class, $monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($monitoring);
            $entityManager->flush();
            $this->addFlash('green', "La sécurité {$monitoring->getName()} à bien été créé.");

            return $this->redirectToRoute('monitoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('monitoring/new.html.twig', [
            'monitoring' => $monitoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'monitoring_show', methods: ['GET'])]
    public function show(Monitoring $monitoring): Response
    {
        return $this->render('monitoring/show.html.twig', [
            'monitoring' => $monitoring,
        ]);
    }

    #[Route('/{id}/edit', name: 'monitoring_edit', methods: ['GET','POST']),
    IsGranted("ROLE_ADMIN")
    ]
    public function edit(Request $request, Monitoring $monitoring): Response
    {
        $form = $this->createForm(MonitoringType::class, $monitoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('monitoring_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('monitoring/edit.html.twig', [
            'monitoring' => $monitoring,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'monitoring_delete', methods: ['POST']),
    IsGranted("ROLE_ADMIN")
]
    public function delete(Request $request, Monitoring $monitoring): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monitoring->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($monitoring);
            $entityManager->flush();
        }

        return $this->redirectToRoute('monitoring_index', [], Response::HTTP_SEE_OTHER);
    }
}
