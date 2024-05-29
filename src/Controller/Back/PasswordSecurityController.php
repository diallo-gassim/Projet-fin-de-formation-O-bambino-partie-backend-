<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Form\Password_securityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordSecurityController extends AbstractController
{
    #[Route('/back/password/security', name: 'app_back_password_security', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $userPassword): Response
    {
          
          // Création d'un formulaire associé à l'entité User
          // ici $form crée le formulaire 
          $form = $this->createForm(Password_securityType::class, $user);
        
       
          // Gestion de la soumission du formulaire
          $form->handleRequest($request);
           dump($user);
  
          // Vérification de la soumission du formulaire et de sa validité
          if ($form->isSubmitted() && $form->isValid()) {
                // SI c'est envoyer et valide
                $user->setPassword($userPassword->hashPassword(
                 $user, 
                $user->getPassword()));// le mot de passe est hashé
            
                 //envoi en BDD
                $entityManager->flush();

                // Message flash de succès
                $this->addFlash('success', 'Le mot de passe à bien été modifier.');
                
                // Redirection vers la liste des utilisateurs après la création de l'utilisateur en admin
                return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
                } 
               
                // SI c'est envoyer mais pas valide
                else if ($form->isSubmitted() && !$form->isValid()) {
    $this->addFlash('error', 'Le mot de passe ne respecte pas les règles requises.');
}
                // Affichage du formulaire et des données associées dans le template
                return $this->render('back/password_security/index.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
    }         
}


 

