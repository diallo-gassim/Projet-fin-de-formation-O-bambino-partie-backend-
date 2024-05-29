<?php

namespace App\Form;

use App\Entity\EventCalendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EventCalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //  Création du formulaire pour ajouter un événement au calendrier
        $builder


        ->add('title', null, [
            'label' => 'Evénement',
            'attr' => ['class' => 'form-control',
            'style' => 'width: 21rem;'],
        ])
        ->add('start', DateType::class, [
            'label' => 'Date de début',
            'attr' => ['class' => 'form-control',
            'style' => 'width: 21rem;'],
            ])
            
            
        ->add('end', DateType::class, [
                'label' => 'Date de fin',
                'attr' => ['class' => 'form-control',
                'style' => 'width: 21rem;'],
    ]);
        
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventCalendar::class,
        ]);
    }
}
