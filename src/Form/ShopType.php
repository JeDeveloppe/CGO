<?php

namespace App\Form;

use App\Entity\Shop;
use App\Entity\Ville;
use App\Repository\ShopRepository;
use App\Repository\VilleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShopType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false
            ])
            ->add('address', TextType::class, [
                'label' => false
            ])
            ->add('ville', EntityType::class, [
                'label' => false,
                'class' => Ville::class,
                'choice_label' => function (Ville $ville) {
                    return $ville->getName() . ' - ' . $ville->getPostalCode();
                },
                'query_builder' => function(VilleRepository $villeRepository) use ($options) {
                    return $villeRepository->findVillesByDepartementsFromCgo($options['cgo']);
                },
                'placeholder' => 'Choisir une ville...'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
            'cgo' => []
        ]);
    }
}
