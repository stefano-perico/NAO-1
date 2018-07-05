<?php

namespace App\Controller\backOffice;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Services\FlashesService;
use App\Services\UserService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class ArticleController extends Controller
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
     * @Route(name="article_index", methods="GET")
     */
    public function article_index(ArticleRepository $articleRepository, Request $request, PaginatorInterface $paginator): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $q = $request->query->get('q');
        $queryBuilder = $articleRepository->getArticleWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('back-office/article/index.html.twig', [
            'pagination'    => $pagination
        ]);
    }

    /**
     * @Route("/article/new", name="article_new", methods="GET|POST")
     */
    public function article_new(Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('back-office/article/new.html.twig', [
            'article' => $article,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods="GET")
     */
    public function article_show(Article $article, Request $request): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        return $this->render('back-office/article/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods="GET|POST")
     */
    public function article_edit(Request $request, Article $article): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_edit', ['id' => $article->getId()]);
        }

        return $this->render('back-office/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods="DELETE")
     */
    public function article_delete(Request $request, Article $article): Response
    {
        if (!$this->userService->isAuthorized($request, __FUNCTION__)){
            $this->flashesService->setFlashes($this->userService->getFlash());
            return $this->redirectToRoute('home');
        };

        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
