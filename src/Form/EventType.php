<?php

namespace App\Form;

use App\Entity\Event;
use App\Repository\UserRepository;
use App\Repository\VillesFranceFreeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{

    private $villesFranceFreeRepository;
    private $userRepository;

    public function __construct(VillesFranceFreeRepository $villesFranceFreeRepository, UserRepository $userRepository)
    {
        $this->villesFranceFreeRepository = $villesFranceFreeRepository;
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('date')
            ->add('content')
            ->add('slug', TextType::class,[
                'required' => false
            ])
            ->add('location', TextType::class)
            ->add('author', ChoiceType::class,[
                'choices'    => $this->userRepository->nameAndId()
            ])
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
