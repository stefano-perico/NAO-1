<?php

namespace App\Controller;

use App\Repository\ObservationRepository;
use App\Services\FlashesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(ObservationRepository $observationRepository, FlashesService $flashesService, Request $request)
    {
        return $this->render('views/home.html.twig',[
            'observations' => $observationRepository->findBy([],['date'=>'desc']),
            'flashs'       => $flashesService->getFlashes($request)
        ]);
    }

}
