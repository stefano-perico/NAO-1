<?php

namespace App\Controller\testDavid;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comments")
 */
class CommentsController extends Controller
{
    /**
     * @Route("/", name="comments_index", methods="GET")
     */
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('testingDavid/comments/index.html.twig', ['comments' => $commentsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="comments_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comments_index');
        }

        return $this->render('testingDavid/comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comments_show", methods="GET")
     */
    public function show(Comments $comment): Response
    {
        return $this->render('testingDavid/comments/show.html.twig', ['comment' => $comment]);
    }

    /**
     * @Route("/{id}/edit", name="comments_edit", methods="GET|POST")
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_edit', ['id' => $comment->getId()]);
        }

        return $this->render('testingDavid/comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comments_delete", methods="DELETE")
     */
    public function delete(Request $request, Comments $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comments_index');
    }
}

///**
// * @Route("/comment", name="comment")
// * @throws \Doctrine\ORM\ORMException
// */
//public function commentForm(Request $request)
//{
//    $entity = new Comments();
//    $entityForm = $this->createForm(CommentType::class, $entity);
//    $entityForm->handleRequest($request);
//
//    if ($entityForm->isSubmitted() && $entityForm->isValid()){
//        $em = $this->get('doctrine.orm.entity_manager');
//        $em->persist($entity);
//        $em->flush();
//    }
//
//    return $this->render('test/index.html.twig', [
//        'form'  => $entityForm->createView()
//    ]);
//}
//
///**
// * @Route("/comments/{article}", name="comments", defaults={"article"=1})
// */
//public function commentShow(CommentsService $commentsService, ArticleRepository $articleRepository, $article): Response
//{
//    $commentaires = $commentsService->getComments($articleRepository->find($article));
//    dump($commentaires);
//
//    return new Response($this->renderView('test/index.html.twig'));
//}
