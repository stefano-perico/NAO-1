<?php

namespace App\Form;

use App\Entity\Position;
use App\Repository\VillesFranceFreeRepository;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionType extends AbstractType
{

    private $villesFranceFreeRepository;

    public function __construct(VillesFranceFreeRepository $villesFranceFreeRepository)
    {
        $this->villesFranceFreeRepository = $villesFranceFreeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('longitude')
            ->add('latitude')
            ->add('address', TextType::class)
        ;
        $builder
            ->get('address')
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
            'data_class' => Position::class,
        ]);
    }
}
