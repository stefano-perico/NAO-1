<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comments;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\CommentType;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Services\CommentsService;
use App\Services\LocationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    /**
     * @Route("/user", name="user")
     * @throws \Doctrine\ORM\ORMException
     */
    public function userForm(Request $request)
    {
        $entity = new User();
        $entityForm = $this->createForm(UserType::class, $entity);
        $entityForm->handleRequest($request);

        if ($entityForm->isSubmitted() && $entityForm->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();
        }

        return $this->render('test/index.html.twig', [
            'form'  => $entityForm->createView()
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function usersShow(UserRepository $repository): Response
    {
        dump($repository->findAll());
        return new Response('<html><body></body></html>');
    }

    /**
     * @Route("/article", name="article")
     * @throws \Doctrine\ORM\ORMException
     */
    public function articleForm(Request $request)
    {
        $entity = new Article();
        $entityForm = $this->createForm(ArticleType::class, $entity);
        $entityForm->handleRequest($request);

        if ($entityForm->isSubmitted() && $entityForm->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();
        }

        return $this->render('test/index.html.twig', [
            'form'  => $entityForm->createView()
        ]);
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function articleShow(ArticleRepository $repository): Response
    {
        dump($repository->findAll());
        return new Response('<html><body></body></html>');
    }

    /**
     * @Route("/category", name="category")
     * @throws \Doctrine\ORM\ORMException
     */
    public function categoryForm(Request $request)
    {
        $entity = new Category();
        $entityForm = $this->createForm(CategoryType::class, $entity);
        $entityForm->handleRequest($request);

        if ($entityForm->isSubmitted() && $entityForm->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();
        }

        return $this->render('test/index.html.twig', [
            'form'  => $entityForm->createView()
        ]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categoryShow(CategoryRepository $repository): Response
    {
        dump($repository->findAll());
        return new Response('<html><body></body></html>');
    }

    /**
     * @Route("/comment", name="comment")
     * @throws \Doctrine\ORM\ORMException
     */
    public function commentForm(Request $request)
    {
        $entity = new Comments();
        $entityForm = $this->createForm(CommentType::class, $entity);
        $entityForm->handleRequest($request);

        if ($entityForm->isSubmitted() && $entityForm->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();
        }

        return $this->render('test/index.html.twig', [
            'form'  => $entityForm->createView()
        ]);
    }

    /**
     * @Route("/comments/{article}", name="comments", defaults={"article"=1})
     */
    public function commentShow(CommentsService $commentsService, ArticleRepository $articleRepository, $article): Response
    {
        $commentaires = $commentsService->getComments($articleRepository->find($article));
        dump($commentaires);

        return new Response('<html><body></body></html>');
    }

    /**
     * @Route("/locationVille/{villeA}/{villeB}", name="locationVille")
     */
    public function locationShow(LocationService $locationService, $villeA, $villeB): Response
    {
        echo '<p>'.$locationService->distanceBetwenVille($villeA,$villeB).' km</p>';
        return new Response('<html><body></body></html>');
    }

    /**
     * @Route("/distanceToVille/{longitude}/{latitude}/{ville}", name="locationSelf")
     */
    public function distanceToVille(LocationService $locationService, $longitude, $latitude,  $ville): Response
    {
        echo '<p>'.$locationService->distanceToVille($latitude, $longitude, $ville).' km</p>';
        return new Response('<html><body></body></html>');
    }

    /**
     * @Route("/single/{title}")
     */
    public function show($title)
    {
        return $this->render('views/single.html.twig', ['title' => $title]);
    }

    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->render('views/home.htm.twig');
    }

}
