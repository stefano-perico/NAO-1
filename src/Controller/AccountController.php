<?php

namespace App\Controller;

use App\Entity\Observation;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ObservationRepository;
use App\Repository\UserRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/compte")
 * Class HomeController
 * @package App\Controller
 */
class AccountController extends Controller
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
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $formLogin = $this
            ->createformBuilder()
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getform()
            ;
        $formLogin->handleRequest($request);

        if ($formLogin->isSubmitted() && $formLogin->isValid()){
            $user = $this->userService->connection($formLogin->getViewData());
            $user !== null ?
                $request->getSession()->set('user', $user):
                null;
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('myAccount');
        }

        return new Response($this->renderView('views/connexion.html.twig',[
            'flashs'    => $this->flashesService->getFlashes($request),
            'formLogin' => $formLogin->createView()
        ]));
    }

    /**
     * @Route("/creer", name="createAccount")
     */
    public function createAccount(Request $request)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $user = new User();
        $formCreateAccount = $this->createForm(UserType::class, $user);
        $formCreateAccount->handleRequest($request);

        if ($formCreateAccount->isSubmitted() && $formCreateAccount->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('myAccount');
        }

        return new Response($this->renderView('views/connexion.html.twig',[
            'flashs'            => $this->flashesService->getFlashes($request),
            'formCreateAccount' => $formCreateAccount->createView()
        ]));
    }

    /**
     * @Route("/mon_compte", name="myAccount")
     */
    public function myAccount(Request $request, UserRepository $userRepository)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        if (!$request->getSession()->has('user')){
            return $this->redirectToRoute('connexion');
        }

        return new Response($this->renderView('views/connexion.html.twig',[
            'flashs'            => $this->flashesService->getFlashes($request),
            'user'              => $userRepository->find($request->getSession()->get('user')),
        ]));
    }

    /**
     * @Route("/disconnect", name="disconnect")
     */
    public function disconnect(Request $request)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $user = $request->getSession()->get('user');
        $request
            ->getSession()
            ->clear();
        $request
            ->getSession()
            ->getFlashBag()
            ->add(
                'primary',
                'Vous êtes maintenant déconnecté <strong>'
                .$user->getFirstName()
                .' '.
                $user->getLastName()
                .'</strong>'
            );
        return $this->redirectToRoute('home');
    }
}
