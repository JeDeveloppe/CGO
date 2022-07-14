<?php

namespace App\Form;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchToCalculateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', EntityType::class, [
                'label' => false,
                'class' => Ville::class,
                'choice_label' => function (Ville $ville) {
                    return $ville->getName() . ' - ' . $ville->getPostalCode();
                },
                'query_builder' => function(VilleRepository $villeRepository) use ($options) {
                    return $villeRepository->findVillesByDepartementsFromCgo($options['cgo']);
                },
                'placeholder' => 'Lieu de l\'intervention...'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'cgo' => [],
        ]);
    }
}
