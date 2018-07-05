<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\ObservationRepository;
use App\Services\FlashesService;
use App\Services\UserService;
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
     * @Route("/", name="home")
     */
    public function home(ObservationRepository $observationRepository, Request $request)
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
                ->add('info', 'Bravo, vous venez de vous abonner à notre Newsletter');
        }

        return $this->render('views/home.html.twig',[
            'observations' => $observationRepository->findBy([],['date'=>'desc'], 6),
            'newsForm'     => $newsletterForm->createView(),
            'flashs'       => $this->flashesService->getFlashes($request)
        ]);
    }

}
