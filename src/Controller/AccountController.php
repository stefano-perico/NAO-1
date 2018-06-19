<?php

namespace App\Controller;

use App\Repository\ObservationRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
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
    public function connexion(Request $request)
    {
        dd($request);
        return $this->redirectToRoute('home');
    }

}
