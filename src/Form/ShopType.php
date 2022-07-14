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

class ShopType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('ville', EntityType::class, [
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
