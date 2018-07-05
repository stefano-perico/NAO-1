<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Newsletter;
use App\Form\CommentType;
use App\Form\NewsletterType;
use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Services\CommentsService;
use App\Services\FlashesService;
use App\Services\UserService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class EvenementController
 * @package App\Controller
 * @Route("/evenement")
 */
class EvenementController extends Controller
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
     * @Route("/index", name="evenementIndex")
     */
    public function evenementIndex(EventRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $q = $request->query->get('q');
        $queryBuilder = $repository->getEventWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

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

        return $this->render('views/evenements/index.html.twig', [
            'pagination'    => $pagination,
            'newsForm'      => $newsletterForm->createView(),
            'flashs'        => $this->flashesService->getFlashes($request)
        ]);
    }

    /**
     * @Route("/evenement/{slug}", name="evenement")
     */
    public function evenement(Request $request, EventRepository $eventRepository, $slug)
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/evenements/evenement.html.twig', [
            'event'                 => $eventRepository->findOneBy(['slug'=>$slug]),
            'eventToDiscover'       => $eventRepository->findBy([],['date'=>'desc'],10,0),
            'flashs'                => $this->flashesService->getFlashes($request)
        ]);
    }
}
