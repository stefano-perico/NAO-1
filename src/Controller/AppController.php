<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
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
    public function article(ArticleRepository $articleRepository, $slug)
    {
//        dd($articleRepository->findOneBy(['slug'=>$slug]));
        return $this->render('views/blog/article.html.twig', [
            'article' => $articleRepository->findOneBy(['slug'=>$slug])
        ]);
    }
}
