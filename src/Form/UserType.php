<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Child;
use App\Repository\ChildRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        //  Création du formulaire pour ajouter un utilisateur
        $builder
        
        ->add('lastname', null, [
            'label' => 'Nom',
            'attr' => [
                'class' => 'form-control',
                'style' => 'width: 21rem;'],
        ])
        

        ->add('firstname', null, [
            'label' => 'Prénom',
            'attr' => [
                'class' => 'form-control',
                'style' => 'width: 21rem;'],
        ])
        

        ->add('email', null, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'width: 21rem;'],
                ]);
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
       
    }
}
