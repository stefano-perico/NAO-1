<?php

namespace App\Form\FrontOffice;

use App\Entity\Observation;
use App\Entity\Taxref;
use App\Form\ImageType;
use App\Form\PositionGeoType;
use App\Repository\ImageRepository;
use App\Repository\TaxrefRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{

    private $imageRepository;
    private $taxrefRepository;

    public function __construct(ImageRepository $imageRepository, TaxrefRepository $taxrefRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->taxrefRepository = $taxrefRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('species', TextType::class,[
                'data_class' => Taxref::class,
            ])
            ->add('description')
            ->add('image', ImageType::class)
            ->add('position', PositionGeoType::class)
        ;

        $builder
            ->get('species')
            ->addModelTransformer(new CallbackTransformer(
                function ($entityToString){
                    dump($entityToString);
                },
                function ($stringToEntity){
                    $match = [];
                    preg_match('/[^()]+/',$stringToEntity,$match);
                    return $this->taxrefRepository->findOneBy(['nom_fr'=>trim($match[0])]);
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
