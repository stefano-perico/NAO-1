<?php

namespace App\Form;

use App\Entity\Comments;
use App\Repository\ArticleRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository, CommentsRepository $commentsRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->commentsRepository = $commentsRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
            $this
                ->setArticle($event)
                ->setAuthor($event)
                ->setParent($event)
            ;
        })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }

    private function setArticle($event)
    {
        $article = $this->articleRepository->find(1);
        $test = $event->getData()->setArticle($article);
        return $this;
    }

    private function setAuthor($event)
    {
        $author = $this->userRepository->find(11);
        $test = $event->getData()->setAuthor($author);
        return $this;
    }

    private function setParent($event)
    {
        $comment = $this->commentsRepository->find(7);
        $test = $event->getData()->setParent($comment);
        return $this;
    }
}
