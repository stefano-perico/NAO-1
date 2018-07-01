<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{

    private $categoryRepository;
    private $userRepository;
    private $imageRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
        ImageRepository $imageRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('summary', TextType::class)
            ->add('content', TextType::class)
            ->add('published')
            ->add('date', DateType::class)
            ->add('slug', TextType::class)
            ->add('author', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
            ->add('categories', ChoiceType::class,[
                'choices'    => $this->categoryRepository->nameAndId()
            ])
            ->add('image', ChoiceType::class,[
                'choices'   => $this->imageRepository->nameAndId()
            ])
        ;
        $builder
            ->get('image')
            ->addModelTransformer(new CallbackTransformer(
                function ($imageAsString){
                    if ($imageAsString !== null){
                        return $imageAsString->getAlt();
                    }
                    return null;
                },
                function ($imageAsEntity){
                    return $imageAsEntity;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
