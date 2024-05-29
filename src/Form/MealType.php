<?php

namespace App\Form;

use App\Entity\Meal;
use App\Entity\Report;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Méthode pour construire le formulaire. Prend un objet `FormBuilderInterface` et un tableau d'options en paramètres.

        $builder

            ->add('weekDay', null, [
                'label' => 'Jour de la semaine'
            ])
            ->add('starter', null, [
                'label' => 'Entrée'
            ])
            // Ajoute un champ "starter" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            // 'label' => 'Entrée': Libellé du champ affiché dans le formulaire.

            ->add('mainMeal', null, [
                'label' => 'Plat'
            ])
            // Ajoute un champ "mainMeal" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            // 'label' => 'Plat': Libellé du champ affiché dans le formulaire.

            ->add('dessert', null, [
                'label' => 'Dessert'
            ])
            // Ajoute un champ "dessert" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            // 'label' => 'Dessert': Libellé du champ affiché dans le formulaire.

            ->add('snack', null, [
                'label' => 'Goûter'
            ])
            // Ajoute un champ "snack" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            // 'label' => 'Goûter': Libellé du champ affiché dans le formulaire.

            ->add('date', null, [
                'label' => 'Date'
            ])
            // Ajoute un champ "date" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            // 'label' => 'Date': Libellé du champ affiché dans le formulaire.

            

            ->add('save', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => ['class' => 'btn btn-success']
            ]);
            // Ajoute un bouton de type "Submit" avec le libellé 'Sauvegarder' et la classe CSS 'btn btn-success'.

            
            // Ajoute un bouton de type "Submit" avec le libellé 'Supprimer' et la classe CSS 'btn btn-danger'.
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configure les options du formulaire.

        $resolver->setDefaults([
            'data_class' => Meal::class,
            'translation_domain' => false,
        ]);
        // Définit les options par défaut. Ici, 'data_class' indique la classe de l'objet associé au formulaire.
        // 'translation_domain' => false: Désactive la traduction pour ce formulaire.
    }
}
