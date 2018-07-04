<?php

namespace App\Form;

use App\Entity\Event;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Repository\VillesFranceFreeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{

    private $villesFranceFreeRepository;
    private $userRepository;
    private $imageRepository;

    public function __construct
    (
        VillesFranceFreeRepository $villesFranceFreeRepository,
        UserRepository $userRepository,
        ImageRepository $imageRepository
    ){
        $this->villesFranceFreeRepository = $villesFranceFreeRepository;
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('date', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('published')
            ->add('content', TextareaType::class,[
                'attr'      => ['class'=>'Tiny', 'rows' => 10],
                'required'  => false
            ])
            ->add('summary', TextareaType::class,[
                'attr'      => ['class'=>'Tiny', 'rows' => 10],
                'required'  => false
            ])
            ->add('slug', TextType::class,[
                'required' => false
            ])
            ->add('location', TextType::class)
            ->add('author', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
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
        $builder
            ->get('location')
            ->addModelTransformer(new CallbackTransformer(
                function ($locationAsString){
                    if ($locationAsString !== null){
                        return $locationAsString->getVilleNom();
                    }
                    return null;
                },
                function ($locationAsEntity){
                    return $this->villesFranceFreeRepository->findOneBy(['villeNom'=>$locationAsEntity]);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }

}
