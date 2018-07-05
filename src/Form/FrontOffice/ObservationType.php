<?php

namespace App\Form\FrontOffice;

use App\Entity\Observation;
use App\Entity\Taxref;
use App\Form\ImageType;
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
                    null;
                },
                function ($stringToEntity){
                    foreach ($this->taxrefRepository->findAll() as $item){
                        if ($stringToEntity === $item->getNomFr().' ('.$item->getLbNom().')'){
                            return $this->taxrefRepository->findOneBy(['id'=>$item->getId()]);
                        }
                    }
                    return null;
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
