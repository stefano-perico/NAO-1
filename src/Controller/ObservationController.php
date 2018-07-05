<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Entity\Observation;
use App\Entity\User;
use App\Form\FrontOffice\ObservationType;
use App\Form\NewsletterType;
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
     * @Route(name="observationIndex")
     */
    public function observationIndex(ObservationRepository $observationRepository, Request $request)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $newsletter =  new Newsletter();
        $newsletterForm =   $this->createForm(NewsletterType::class, $newsletter);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('info', 'Bravo, vous venez de vous abonner à notre Newsletter')
            ;
        }

        return $this->render('views/observation/observationInfo.html.twig',[
            'observations' => $observationRepository->findBy([],['date'=>'desc']),
            'newsForm'      => $newsletterForm->createView(),
            'elementPage'  => Yaml::parseFile($this->getParameter('kernel.project_dir').'/translations/observation.yaml'),
            'flashs'       => $this->flashesService->getFlashes($request)
        ]);
    }

    /**
     * @Route("/creer", name="observationCreate")
     */
    public function observationCreate(Request $request, UserRepository $userRepository)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

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
            }
        }


        return new Response($this->renderView('views/observation/observationCreate.html.twig',[
            'elementPage'       => Yaml::parseFile($this->getParameter('kernel.project_dir').'/translations/observation.yaml'),
            'observationForm'   => $observationForm->createView(),
            'flashs'            => $this->flashesService->getFlashes($request)
        ]));
    }

}
