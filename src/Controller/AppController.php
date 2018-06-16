<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use App\Services\CommentsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AppController
 * @package App\Controller
 * @Route("/blog")
 */
class AppController extends Controller
{
    /**
     * @Route("/index", name="blogIndex")
     */
    public function blog(ArticleRepository $articleRepository)
    {
//        dd($articleRepository->findAll());
        return $this->render('views/blog/index.html.twig', [
            'articles' => $articleRepository->findAll()
        ]);
    }

    /**
     * @Route("/article/{slug}", name="blogArticle")
     */
    public function article(Request $request, ArticleRepository $articleRepository,UserRepository $userRepository, CommentsRepository $commentsRepository, CommentsService $commentsService, $slug)
    {
        $article = $articleRepository->findOneBy(['slug'=>$slug]);

        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $userRepository->find(1);
            $parent = $commentsRepository->find(1);
            $comment
                ->setArticle($article)
                ->setAuthor($user)
                ->setParent($parent)
            ;
            if  ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute('blogArticle',['slug'=>$slug]);
            }
        }

        return $this->render('views/blog/article.html.twig', [
            'article' => $article,
            'articlestodiscover' => $articleRepository->findAll(),
            'comments' => $commentsService->getComments($article),
            'comment'=> $form->createView()
        ]);
    }
}
