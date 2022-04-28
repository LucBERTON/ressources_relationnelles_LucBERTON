<?php

namespace App\Form;

use App\Entity\Citizen;
use App\Entity\Ressource;
use App\Entity\RelationType;
use App\Entity\RessourceCategory;
use App\Entity\RessourceType as EntityRessourceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class)
            ->add('content',TextType::class)
            ->add('url',TextType::class)
            ->add('views',TextType::class)
            ->add('submitDate',DateType::class)
            ->add('status',TextType::class)
            ->add('moderationStatus',TextType::class)
            ->add('moderationDate',DateType::class)
            ->add('sharedWith',EntityType::class,[
                'class'=>Citizen::class,
                'multiple' => true,
                'choice_label' => 'firstName'
            ])
            ->add('moderator',EntityType::class, [
                'class' => Citizen::class,
                'choice_label'=> 'firstName'
            ])
            ->add('submitter',EntityType::class,[
                'class' => Citizen::class,
                'choice_label' => 'firstName'
            ])
            ->add('category',EntityType::class,[
                'class' => RessourceCategory::class,
                'choice_label' => 'name'
            ])
            ->add('type',EntityType::class,[
                'class' => EntityRessourceType::class,
                'choice_label' => 'name'
            ])
            
            ->add('relationType',EntityType::class,[
                'class' => RelationType::class,
                'multiple'=>true,
                 'choice_label'=> 'name'
                  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
