<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Méthode pour construire le formulaire. Prend un objet `FormBuilderInterface` et un tableau d'options en paramètres.
        $builder
            // Ajoute un champ "lastname" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).
            ->add('lastname',null,[
                'label' => 'Nom'
            ]) 
            
             // Ajoute un champ "firstname" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).   
            ->add('firstname',null,[
                'label' => 'Prénom'
            ]) 
            
            // Ajoute un champ "email" au formulaire. Le type du champ est automatiquement déduit (ici, un champ texte).    
            ->add('email')
            
            // Ajoute un champ de type case à cocher pour accepter les termes. Non mappé à l'entité.    
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Acceptez les termes.',
                    ]),
                ],
            ])
            
                // Ajoute un champ de type choix pour les rôles (utilisateur ou administrateur).
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    // 'Utilisateur (USER)' => 'ROLE_USER',
                    'Administrateur (ADMIN)' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles',
            ])
            // Ajoute un champ de type mot de passe pour le mot de passe de l'utilisateur.
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => ' Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe'
                    ]),
                    
                    new Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',"Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.")
                ],
                ])
                
            
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary']
                ]);
           
            // Ajoute un champ de type mot de passe pour le mot de passe de l'utilisateur. Non mappé à l'entité.
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configure les options du formulaire.

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
        // Définit les options par défaut. Ici, 'data_class' indique la classe de l'objet associé au formulaire.
    }
}

