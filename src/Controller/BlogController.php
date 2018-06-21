<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Services\CommentsService;
use App\Services\FlashesService;
use App\Services\UserService;
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
     * @Route("/index", name="blogIndex")
     */
    public function blogIndex(ArticleRepository $articleRepository, Request $request, FlashesService $flashesService, UserService $userService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('views/blog/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'flashs'   => $flashesService->getFlashes($request)
        ]);
    }

    /**
     * @Route("/article/{slug}", name="blogArticle")
     */
    public function blogArticle(Request $request, FlashesService $flashesService, ArticleRepository $articleRepository,UserRepository $userRepository, CommentsService $commentsService, $slug, UserService $userService)
    {
        if (!$userService->isAuthorized($request, __FUNCTION__)){
            $flashesService->setFlashes($userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $article = $articleRepository->findOneBy(['slug'=>$slug]);
        $comment = (new Comments())
            ->setArticle($article)
            ->setAuthor(
                $userRepository->find($request->getSession()->get('user')->getId())
            )
        ;
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('blogArticle',['slug'=>$slug]);
        }

        return $this->render('views/blog/article.html.twig', [
            'article' => $article,
            'articlestodiscover' => $articleRepository->findAll(),
            'comments' => $commentsService->getComments($article),
            'comment'=> $form->createView(),
            'flashs'       => $flashesService->getFlashes($request)
        ]);
    }
}
