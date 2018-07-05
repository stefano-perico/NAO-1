<?php

namespace App\Controller\backOffice;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/event")
 */
class EventController extends Controller
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
     * @Route("/", name="event_index", methods="GET")
     */
    public function event_index(EventRepository $eventRepository, PaginatorInterface $paginator, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $q = $request->query->get('q');
        $queryBuilder = $eventRepository->getEventWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

//        dd($eventRepository->findAll());
        return $this->render('back-office/event/index.html.twig', [
                'pagination' => $pagination
            ]);
    }

    /**
     * @Route("/new", name="event_new", methods="GET|POST")
     */
    public function event_new(Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('back-office/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods="GET")
     */
    public function event_show(Event $event, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('back-office/event/show.html.twig', ['event' => $event]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods="GET|POST")
     */
    public function event_edit(Request $request, Event $event): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', ['id' => $event->getId()]);
        }

        return $this->render('back-office/event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods="DELETE")
     */
    public function event_delete(Request $request, Event $event): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
