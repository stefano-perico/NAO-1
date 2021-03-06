<?php

namespace App\Services;


use App\Entity\Article;
use App\Repository\CommentsRepository;

class CommentsService
{

    private $commentsRepository;

    private $formatedComments = [];

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function setComments(array $comments): self
    {
        $commentsById = [];
        $commentsByParent = [];

        foreach ($comments as $comment) {
            $commentsById[$comment->getId()] = $comment;
        }

        foreach ($commentsById as $k => $v) {
            $class = new \stdClass();
            null !== $v->getParent()?$class->parent = $v->getParent()->getId():$class->parent = null;
            $class->comment = $v;
            $class->children = null;
            $commentsByParent[$k] = $class;
        }

        $this->formatedComments = $commentsByParent;
        foreach ($this->formatedComments as $k => $item){
            if ($item->parent !== null){
                $commentsByParent[$item->parent]->children[] = $item;
                unset($this->formatedComments[$k]);
            }
        }
        return $this;
    }

    public function setCommentsByOrder()
    {
        $comments = $this->formatedComments;
        $this->formatedComments = [];

        foreach ($comments as $comment){
            $this->formatedComments[] = $comment->comment;
            if ($comment->children !== null){
                $this->recursivity($comment, 1);
            }
        }
    }

    public function recursivity($comment, $lvl)
    {
        foreach ($comment->children as $comment) {
            $comment->comment->lvl = $lvl;
            $this->formatedComments[] = $comment->comment;
            if ($comment->children !== null){
                $this->recursivity($comment, $lvl+1);
            }
        }
    }

    public function getComments(Article $article): array
    {
        $comments = $this->commentsRepository->findBy(['article'=>$article]);
        $this
            ->setComments($comments)
            ->setCommentsByorder()
        ;
        return $this->formatedComments;
    }
}