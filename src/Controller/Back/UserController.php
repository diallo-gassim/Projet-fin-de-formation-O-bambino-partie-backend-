<?php

namespace App\Controller\Back;

// On importe des outils nécessaires de Symfony
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ChildRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
#[Route('/back/user')]
class UserController extends AbstractController
{
    // Route pour afficher la liste des utilisateurs (méthode GET)
    #[Route('/', name: 'app_back_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Récupération de tous les utilisateurs depuis le repository
        return $this->render('back/user/index.html.twig', [
            'users' => $userRepository->findAll(),  
        ]);
    }

    // Route pour créer un nouvel utilisateur (méthodes GET et POST)
    #[Route('/new', name: 'app_back_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPassword): Response
    {
        // Création d'une nouvelle instance de la classe User
        $user = new User();
        // Création d'un formulaire associé à l'entité User
        $form = $this->createForm(UserType::class, $user);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPassword->hashPassword($user, $user->getPassword()));
            // Persistance de l'objet User en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection vers la liste des utilisateurs après la création
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'un utilisateur (méthode GET)
    #[Route('/{id}', name: 'app_back_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        // Affichage des détails de l'utilisateur dans le template
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    // Route pour éditer un utilisateur existant (méthodes GET et POST)
    #[Route('/{id}/edit', name: 'app_back_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        // Création d'un formulaire pré-rempli avec les données de l'utilisateur
        $form = $this->createForm(UserType::class, $user);
        
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);
        

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
          
            // Mise à jour de l'utilisateur en base de données
            $entityManager->flush();

            // Redirection vers la liste des utilisateurs après la modification
            return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    

    // Route pour supprimer un utilisateur (méthode POST)
    #[Route('/{id}', name: 'app_back_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF pour éviter les attaques de type Cross-Site Request Forgery(https://docs.djangoproject.com/fr/5.0/ref/csrf/)
    // if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            // Suppression de l'utilisateur en base de données
            $entityManager->remove($user);
            $entityManager->flush();
    // }

        // Redirection vers la liste des utilisateurs après la suppression
        return $this->redirectToRoute('app_back_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
