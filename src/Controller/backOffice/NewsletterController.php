<?php

namespace App\Controller\backOffice;

use App\Entity\Newsletter;
use App\Form\Newsletter1Type;
use App\Repository\NewsletterRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class NewsletterController extends Controller
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
     * @Route("/newsletter",name="newsletter_index", methods="GET")
     */
    public function newsletter_index(NewsletterRepository $newsletterRepository, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        file_put_contents('emailsNewsLetter.txt', $this->renderView('views/newsletterRender.html.twig',[
            'mails' => $newsletterRepository->findAll()
        ]));
        return $this->render('back-office/newsletter/index.html.twig', [
            'newsletters' => $newsletterRepository->findAll()
        ]);
    }

}
