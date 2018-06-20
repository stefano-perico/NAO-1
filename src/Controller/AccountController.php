<?php

namespace App\Controller;

use App\Repository\ObservationRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use function Sodium\add;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

/**
 * Class HomeController
 * @package App\Controller
 */
class AccountController extends Controller
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(Request $request, FlashesService $flashesService, UserService $userService)
    {
//        $request->getSession()->clear();

        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

//        $request->getSession()->clear();
        dump($request->getSession()->get('user'));
        $form = $this
            ->createFormBuilder()
            ->add('email')
            ->add('password')
            ->getForm()
            ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $userService->connection($form->getViewData());
            $user !== null ?
                $request->getSession()->set('user', $user):
                null;
            $flashesService->setFlashes($userService->getFlash());
        }

        return new Response($this->renderView('views/connexion.html.twig',[
            'flashs'    => $flashesService->getFlashes($request),
            'form'      => $form->createView()
        ]));
    }

}
