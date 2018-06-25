<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class,[
                'label' => false
            ])
            ->add('alt', TextType::class,[
                'required' => false,
                'label'    => false
            ])
            ->add('section', ChoiceType::class,[
                'choices' => [
                    'indéfini'      => 'indefini',
                    'article'       => 'article',
                    'évènement'     => 'evenement',
                    'observation'   => 'observation'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
