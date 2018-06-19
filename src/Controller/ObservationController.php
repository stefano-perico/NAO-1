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
class ObservationController extends Controller
{
    /**
     * @Route("/observation", name="observation")
     */
    public function observation(ObservationRepository $observationRepository, Request $request, UserService $userService, FlashesService $flashesService)
    {
        $user = ['role' => 'visitor'];
        $request->getSession()->set('user', $user);

        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/observation.html.twig',[
            'observations' => $observationRepository->findBy([],['date'=>'desc']),
            'elementPage'  => Yaml::parseFile($this->getParameter('kernel.project_dir').'/translations/test.yaml'),
            'flashs'       => $flashesService->getFlashes($request)
        ]);
    }

}
