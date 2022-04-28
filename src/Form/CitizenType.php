<?php

namespace App\Form;

use App\Entity\Citizen;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CitizenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('password', PasswordType::class, array(
                'label' => 'Mot de passe'
            ))
            ->add('firstName', TextType::class, array(
                'label' => "Prénom"
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom de famille'
            ))
            ->add('streetName', TextType::class, array(
                'label' => 'Rue'
            ))
            ->add('streetNumber', TextType::class, array(
                'label' => 'Numéro'
            ))
            ->add('postalCode', TextType::class, array(
                'label' => 'Code postal'
            ))
            ->add('city', TextType::class, array(
                'label' => 'Commune'
            ))
            ->add('country', TextType::class, array(
                'label' => 'Pays'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citizen::class,
        ]);
    }
}
