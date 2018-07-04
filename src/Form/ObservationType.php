<?php

namespace App\Form;

use App\Entity\Observation;
use App\Entity\Position;
use App\Entity\Taxref;
use App\Repository\ImageRepository;
use App\Repository\TaxrefRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{

    private $userRepository;
    private $imageRepository;
    private $taxrefRepository;

    public function __construct(UserRepository $userRepository, ImageRepository $imageRepository, TaxrefRepository $taxrefRepository)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
        $this->taxrefRepository = $taxrefRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('species', TextType::class)
            ->add('date', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('checked')
            ->add('author', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
            ->add('image', ChoiceType::class,[
                'choices'   => $this->imageRepository->nameAndId(),
                'required' => false,
            ])
            ->add('verifiedBy', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
            ->add('position', PositionType::class)
        ;
        $builder
            ->get('species')
            ->addModelTransformer(new CallbackTransformer(
                function ($speciesAsString){
                    if ($speciesAsString !== null){
                        return $speciesAsString->getNomFr();
                    }
                    return null;
                },
                function ($speciesAsEntity){
                    return $this->taxrefRepository->findOneBy(['nom_fr'=>$speciesAsEntity]);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Observation::class,
        ]);
    }
}
