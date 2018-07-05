<?php

namespace App\Controller\backOffice;

use App\Entity\Position;
use App\Form\PositionType;
use App\Repository\PositionRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/position")
 */
class PositionController extends Controller
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
     * @Route("/", name="position_index", methods="GET")
     */
    public function position_index(PositionRepository $positionRepository, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('back-office/position/index.html.twig', ['positions' => $positionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="position_new", methods="GET|POST")
     */
    public function position_new(Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $position = new Position();
        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($position);
            $em->flush();

            return $this->redirectToRoute('position_index');
        }

        return $this->render('back-office/position/new.html.twig', [
            'position' => $position,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="position_show", methods="GET")
     */
    public function position_show(Position $position, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('back-office/position/show.html.twig', ['position' => $position]);
    }

    /**
     * @Route("/{id}/edit", name="position_edit", methods="GET|POST")
     */
    public function position_edit(Request $request, Position $position): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('position_edit', ['id' => $position->getId()]);
        }

        return $this->render('back-office/position/edit.html.twig', [
            'position' => $position,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="position_delete", methods="DELETE")
     */
    public function position_delete(Request $request, Position $position): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        if ($this->isCsrfTokenValid('delete'.$position->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($position);
            $em->flush();
        }

        return $this->redirectToRoute('position_index');
    }
}
