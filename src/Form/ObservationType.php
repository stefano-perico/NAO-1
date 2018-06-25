<?php

namespace App\Form;

use App\Entity\Observation;
use App\Entity\Position;
use App\Entity\Taxref;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('description')
            ->add('species', EntityType::class,
                [
                    'class'     =>  Taxref::class,
                ])
            ->add('date')
            ->add('checked')
            ->add('author', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
            ->add('image', ChoiceType::class,[
                'choices'   => $this->imageRepository->nameAndId()
            ])
            ->add('verifiedBy', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
            ->add('position', PositionType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
