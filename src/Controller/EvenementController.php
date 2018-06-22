<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Services\CommentsService;
use App\Services\FlashesService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class EvenementController
 * @package App\Controller
 * @Route("/evenement")
 */
class EvenementController extends Controller
{
    /**
     * @Route("/index", name="evenementIndex")
     */
    public function evenementIndex(EventRepository $eventRepository, Request $request, FlashesService $flashesService, UserService $userService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/evenements/index.html.twig', [
            'events' => $eventRepository->findAll(),
            'flashs'   => $flashesService->getFlashes($request)
        ]);
    }

    /**
     * @Route("/evenement/{slug}", name="evenement")
     */
    public function evenement(Request $request, FlashesService $flashesService, EventRepository $eventRepository, UserRepository $userRepository, $slug, UserService $userService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        dump($eventRepository->find(2)->getLocation());

        return $this->render('views/evenements/evenement.html.twig', [
            'event'                 => $eventRepository->findOneBy(['slug'=>$slug]),
            'eventToDiscover'       => $eventRepository->findBy([],['date'=>'desc'],10,0),
            'flashs'                => $flashesService->getFlashes($request)
        ]);
    }
}
