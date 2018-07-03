<?php

namespace App\Form;

use App\Entity\Comments;
use App\Repository\ArticleRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{

    private $articleRepository;
    private $userRepository;
    private $commentsRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository, CommentsRepository $commentsRepository)
    {
        $this->articleRepository    = $articleRepository;
        $this->userRepository       = $userRepository;
        $this->commentsRepository   = $commentsRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class,[
                'attr'      => ['rows' => 10]
            ])
            ->add('article', TextType::class)
            ->add('author', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
        ;
        $builder
            ->get('article')
            ->addModelTransformer(new CallbackTransformer(
                function ($articleAsId){
                    if ($articleAsId !== null){
                        return $articleAsId->getTitle();
                    }
                    return null;
                },
                function ($articleAsEntity){
                    return $this->articleRepository->findOneBy(['title'=>$articleAsEntity]);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
