<?php

namespace App\Form;

use App\Entity\Absence;
use App\Entity\Child;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbsenceType extends AbstractType
{
    // Déclare le namespace du fichier.

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Méthode pour construire le formulaire. Prend un objet `FormBuilderInterface` et un tableau d'options en paramètres.

        $builder
        // Objet permettant de définir la structure du formulaire.

        // Ajoute un champ "startDate" de type DateType au formulaire. Il représente la date de début de l'absence.
            ->add('startDate', DateType::class, [

                // 'label' => 'Date de début': Libellé du champ affiché dans le formulaire.
                'label' => 'Date de début',

                // 'attr' => ['class' => 'form-control']: Attributs HTML supplémentaires, ici une classe CSS.
                'attr' => [
                    'class' => 'form-control',
                    'style' =>'width: 21rem',
                ],
            ])
            
            
            
            // Ajoute un champ "endDate" de type DateType au formulaire. Il représente la date de fin de l'absence.
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'attr' => [
                    'class' => 'form-control',
                    'style' =>'width: 21rem',
                ],
            ])

            // Ajoute un champ "comment" de type TextareaType au formulaire. Il représente le commentaire associé à l'absence. Les options sont similaires à celles des champs précédents.
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                    'style' =>'width: 21rem',
            ],
            ])

            // Ajoute un champ "comment" de type TextareaType au formulaire. Il représente le commentaire associé à l'absence. Les options sont similaires à celles des champs précédents.
            ->add('child', EntityType::class, [
                'class' => Child::class,
                'label' => 'Enfant',
                'attr' => ['class' => 'form-control',
                'style' =>'width: 21rem',
                ],
                'choice_label' => 'firstname'
                
            ]);
           
    }

    // Méthode pour configurer les options du formulaire. Prend un objet `OptionsResolver` en paramètre.
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Absence::class,
        ]);
        
    }
}
