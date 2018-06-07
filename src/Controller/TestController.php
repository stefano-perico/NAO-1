<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
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
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('views/home.html.twig');
    }

    /**
     * @Route("/show/{slug})
     */
    public function show($slug)
    {
        return $this->render('single.html.twig', [sprintf('slug', $slug)]);
    }


}
