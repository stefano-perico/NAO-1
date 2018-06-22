<?php

namespace App\Controller\backOffice;

use App\Entity\Observation;
use App\Form\ObservationType;
use App\Repository\ObservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/observation")
 */
class ObservationController extends Controller
{
    /**
     * @Route("/", name="observation_index", methods="GET")
     */
    public function index(ObservationRepository $observationRepository): Response
    {
        return $this->render('back-office/observation/index.html.twig', ['observations' => $observationRepository->findAll()]);
    }

    /**
     * @Route("/new", name="observation_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();

            return $this->redirectToRoute('observation_index');
        }

        return $this->render('back-office/observation/new.html.twig', [
            'observation' => $observation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="observation_show", methods="GET")
     */
    public function show(Observation $observation): Response
    {
        return $this->render('back-office/observation/show.html.twig', ['observation' => $observation]);
    }

    /**
     * @Route("/{id}/edit", name="observation_edit", methods="GET|POST")
     */
    public function edit(Request $request, Observation $observation): Response
    {
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('observation_edit', ['id' => $observation->getId()]);
        }

        return $this->render('back-office/observation/edit.html.twig', [
            'observation' => $observation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="observation_delete", methods="DELETE")
     */
    public function delete(Request $request, Observation $observation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$observation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($observation);
            $em->flush();
        }

        return $this->redirectToRoute('observation_index');
    }
}
