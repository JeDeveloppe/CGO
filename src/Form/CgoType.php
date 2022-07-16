<?php

namespace App\Form;

use App\Entity\Cgo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CgoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'ROLE_ADMIN' => 'ADMIN',
            //         'ROLE_USER' => 'USER'
            //         ]
            // ])
            ->add('password', PasswordType::class)
            ->add('new_password', TextType::class, [
                'label' => 'Nouveau mot de passe:',
                'mapped' => false,
                'required' => false
            ])
            ->add('name')
            // ->add('departements')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cgo::class,
        ]);
    }
}
