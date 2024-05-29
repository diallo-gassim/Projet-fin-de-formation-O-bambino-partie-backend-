<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\User;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //  Création du formulaire pour ajouter un enfant
        
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Parent',
                'choice_label' => 'firstname', 
                'placeholder' => 'Sélectionnez le parent',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'
                ],
            ])
            
            ->add('lastname', null, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'
                ],
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'
                ],
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'
                ],
            ])
            ->add('gender', null, [
                'label' => 'Genre',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'
                ],
            ])
            ->add('diet', null, [
                'label' => 'Régime alimentaire',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'
                ],
            ]);
            
    }

    //  Configuration des options du formulaire
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}