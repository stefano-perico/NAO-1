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
    public function connexion(Request $request, FlashesService $flashesService)
    {
        $connexionForm = $this
            ->createFormBuilder()
            ->add('firstname')
            ->add('password')
            ->getForm()
            ;

        $connexionForm->handleRequest($request);

        if ($connexionForm->isSubmitted() && $connexionForm->isValid()){
            dd($connexionForm);
        }

        return new Response($this->renderView('views/connexion.html.twig',[
            'flashs'        => $flashesService->getFlashes($request),
            'connexionForm' => true
        ]));
    }

}
