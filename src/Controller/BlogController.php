<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Newsletter;
use App\Form\FrontOffice\CommentType;
use App\Form\NewsletterType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Services\CommentsService;
use App\Services\FlashesService;
use App\Services\UserService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route(name="blogIndex")
     */
    public function blogIndex(ArticleRepository $repository, Request $request, FlashesService $flashesService, UserService $userService, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $repository->getArticleWithSearchQueryBuilder($q);

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

        return $this->render('views/blog/index.html.twig', [
            'pagination' => $pagination,
            'newsForm'     => $newsletterForm->createView(),
            'flashs'   => $flashesService->getFlashes($request)
        ]);
    }


    /**
     * @Route("/{slug}", name="blogArticle")
     */
    public function blogArticle(Request $request, FlashesService $flashesService, ArticleRepository $articleRepository,UserRepository $userRepository, CommentsService $commentsService, $slug, UserService $userService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $article = $articleRepository->findOneBy(['slug'=>$slug]);

        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->getSession()->has('user')){
                $comment
                    ->setArticle($article)
                    ->setAuthor($userRepository->find($request->getSession()->get('user')->getId()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute('blogArticle',['slug'=>$slug]);
            }
            $request->getSession()->getFlashBag()->add('warning','Pour poster un commentaire vous devez être connecté');
        }

        return $this->render('views/blog/article.html.twig', [
            'article'               => $article,
            'articlestodiscover'    => $articleRepository->findAll(),
            'comments'              => $commentsService->getComments($article),
            'comment'               => $form->createView(),
            'flashs'                => $flashesService->getFlashes($request)
        ]);
    }
}
