<?php

namespace App\Controller\backOffice;

use App\Entity\Observation;
use App\Form\ObservationType;
use App\Repository\ObservationRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Knp\Component\Pager\PaginatorInterface;
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
     * @var UserService
     */
    private $userService;
    /**
     * @var FlashesService
     */
    private $flashesService;

    public function __construct(UserService $userService, FlashesService $flashesService)
    {
        $this->userService = $userService;
        $this->flashesService = $flashesService;
    }

    /**
     * @Route("/", name="observation_index", methods="GET")
     */
    public function observation_index(ObservationRepository $observationRepository, PaginatorInterface $paginator, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $q = $request->query->get('q');
        $queryBuilder = $observationRepository->getSpeciesObsWithSearchQueryBuilderIndex($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('back-office/observation/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/new", name="observation_new", methods="GET|POST")
     */
    public function observation_new(Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

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
    public function observation_show(Observation $observation, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('back-office/observation/show.html.twig', ['observation' => $observation]);
    }

    /**
     * @Route("/{id}/edit", name="observation_edit", methods="GET|POST")
     */
    public function observation_edit(Request $request, Observation $observation): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

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
    public function observation_delete(Request $request, Observation $observation): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        if ($this->isCsrfTokenValid('delete'.$observation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($observation);
            $em->flush();
        }

        return $this->redirectToRoute('observation_index');
    }
}
