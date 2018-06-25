<?php

namespace App\Form\FrontOffice;

use App\Entity\Observation;
use App\Form\ImageType;
use App\Form\PositionGeoType;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{

    private $userRepository;
    private $imageRepository;

    public function __construct(UserRepository $userRepository, ImageRepository $imageRepository)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species')
            ->add('description')
            ->add('image', ImageType::class)
            ->add('position', PositionGeoType::class,[
                'label' => false,
                'attr'  => ['hidden'=>true]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
