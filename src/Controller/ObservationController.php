<?php

namespace App\Controller;

use App\Entity\Observation;
use App\Entity\User;
use App\Form\FrontOffice\ObservationType;
use App\Repository\ObservationRepository;
use App\Repository\UserRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/observation")
 */
class ObservationController extends Controller
{
    /**
     * @Route(name="observationIndex")
     */
    public function observationIndex(ObservationRepository $observationRepository, Request $request, UserService $userService, FlashesService $flashesService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/observation/observationInfo.html.twig',[
            'observations' => $observationRepository->findBy([],['date'=>'desc']),
            'elementPage'  => Yaml::parseFile($this->getParameter('kernel.project_dir').'/translations/test.yaml'),
            'flashs'       => $flashesService->getFlashes($request)
        ]);
    }

    /**
     * @Route("/creer", name="observationCreate")
     */
    public function observationCreate(Request $request, FlashesService $flashesService, UserService $userService, UserRepository $userRepository)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        }

        $observation = new Observation();
        $observationForm = $this->createForm(ObservationType::class, $observation);
        $observationForm->handleRequest($request);

        if ($observationForm->isSubmitted() && $observationForm->isValid()) {
            if (!$request->getSession()->has('user')){
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('warning', 'Vous devez être <strong>connecté</strong> pour poster une observation');
            }else{
                $observation
                    ->setAuthor($userRepository->find($request->getSession()->get('user')->getId()))
                ;
                $em = $this->getDoctrine()->getManager();
                $em->persist($observation);
                $em->flush();

                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('warning', 'Votre observation sera prise en compte sous peu')
                ;
//                return $this->redirectToRoute('myAccount');
            }
        }

        return new Response($this->renderView('views/observation/observationCreate.html.twig',[
            'elementPage'       => Yaml::parseFile($this->getParameter('kernel.project_dir').'/translations/test.yaml'),
            'observationForm'   => $observationForm->createView(),
            'flashs'            => $flashesService->getFlashes($request)
        ]));
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(Request $request, EntityManagerInterface $em)
    {
        $observation = new Observation();
        $observationForm = $this->createForm(ObservationType::class, $observation);
        $observationForm->handleRequest($request);

        if ($observationForm->isSubmitted() && $observationForm->isValid()) {
            $author = $em->getRepository(User::class)->find(1);//FIXME: à modifier

            $observation->setAuthor($author);

            $em->persist($observation);
            $em->flush();
        }
        return new Response($this->renderView('new.html.twig',[
            'observationForm' => $observationForm->createView()
        ]));
    }
}
