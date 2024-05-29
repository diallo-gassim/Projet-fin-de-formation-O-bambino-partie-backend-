<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\Report;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;




use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Méthode pour construire le formulaire. Prend un objet `FormBuilderInterface` et un tableau d'options en paramètres.

        $builder

        // Ajoute un champ de type entité pour sélectionner un enfant associé à ce rapport.
        ->add('child_report', EntityType::class, [
            'label' => 'Enfant',
            'class' => Child::class,
            'choice_label' => 'firstname',
        ])


       // Ajoute un champ "dateReport" au formulaire. Le type du champ est automatiquement déduit (ici, un champ de type date).
        ->add('dateReport', DateType::class, [
            'label' => 'Date du rapport',
            'attr' => ['class' => 'form-control',
            'style' => 'width: 21rem;'],

        ])
        

            // Ajoute un champ "mealReport" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            ->add('mealReport', null, [

                'label' => 'Rapport repas',
                'attr' => ['class' => 'form-control',
                'style' => 'width: 21rem;'],
            ])
            
            // Ajoute un champ "toiletReport" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            ->add('toiletReport', null, [
                'label' => 'Rapport toilette',
                'attr' => ['class' => 'form-control',
                'style' => 'width: 21rem;'],
            ])
            
            // Ajoute un champ "sleepReport" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            ->add('sleepReport', null       , [
                'label' => 'Rapport sommeil',
                'attr' => ['class' => 'form-control',
                'style' => 'width: 21rem;'],

            ])
            
             // Ajoute un champ "reminder" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            ->add('reminder', TextareaType::class, [

                'label' => 'Commentaire',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'],
                ]);
           

            

            

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configure les options du formulaire.

        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
        // Définit les options par défaut. Ici, 'data_class' indique la classe de l'objet associé au formulaire.
    }
}