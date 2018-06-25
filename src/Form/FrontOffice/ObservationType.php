<?php

namespace App\Form\FrontOffice;

use App\Entity\Image;
use App\Entity\Observation;
use App\Entity\Taxref;
use App\Form\ImageType;
use App\Form\PositionGeoType;
use App\Repository\ImageRepository;
use App\Repository\TaxrefRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('image', FileType::class,[
                'data_class' => Image::class
            ])
            ->add('position', PositionGeoType::class)
        ;

        $builder
            ->get('image')
            ->addModelTransformer(new CallbackTransformer(
                function ($entityToString){
//                    dd($entityToString);
                },
                function ($stringToEntity){
                    dump($stringToEntity);
                }))
        ;

        $builder
            ->get('species')
            ->addModelTransformer(new CallbackTransformer(
                function ($entityToString){
                    dump($entityToString);
                },
                function ($stringToEntity){
                    dump($stringToEntity);
                    return $this->taxrefRepository->findOneBy(['lb_nom'=>$stringToEntity]);
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
