<?php

namespace App\Form;

use App\Entity\Event;
use App\Repository\UserRepository;
use App\Repository\VillesFranceFreeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('publishedAt')
            ->add('UpdatedAt')
            ->add('content')
            ->add('slug')
//            ->add('location', ChoiceType::class)
//            ->add('author')
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
                $this
                    ->setLocation($event)
                    ->setAuthor($event)
                ;
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }

    private function setLocation($event)
    {
        $location = $this->villesFranceFreeRepository->findOneBy(['villeNom'=>'toulouse']);
        $event->getData()->setLocation($location);
        return $this;
    }

    private function setAuthor($event)
    {
        $author = $this->userRepository->findOneBy(['id'=>1]);
        $event->getData()->setAuthor($author);
        return $this;
    }

}
