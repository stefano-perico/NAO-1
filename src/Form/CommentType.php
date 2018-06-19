<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{

    private $articleRepository;
    private $userRepository;
    private $commentsRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository, CommentsRepository $commentsRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->commentsRepository = $commentsRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('parent', HiddenType::class,[
                'data' => null
            ])
            ->get('parent')
            ->addModelTransformer(new CallbackTransformer(
                function ($null){
                    return $null;
                },
                function($id){
                    return $this->commentsRepository->findOneBy(['id'=>$id]);
                })
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }

}
