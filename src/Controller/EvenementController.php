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
     * @Route("/index", name="evenementIndex")
     */
    public function evenementIndex(EventRepository $repository, Request $request, FlashesService $flashesService, UserService $userService, PaginatorInterface $paginator)
    {
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

        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/evenements/index.html.twig', [
            'pagination'    => $pagination,
            'newsForm'      => $newsletterForm->createView(),
            'flashs'        => $flashesService->getFlashes($request)
        ]);
    }

    /**
     * @Route("/evenement/{slug}", name="evenement")
     */
    public function evenement(Request $request, FlashesService $flashesService, EventRepository $eventRepository, UserRepository $userRepository, $slug, UserService $userService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/evenements/evenement.html.twig', [
            'event'                 => $eventRepository->findOneBy(['slug'=>$slug]),
            'eventToDiscover'       => $eventRepository->findBy([],['date'=>'desc'],10,0),
            'flashs'                => $flashesService->getFlashes($request)
        ]);
    }
}
