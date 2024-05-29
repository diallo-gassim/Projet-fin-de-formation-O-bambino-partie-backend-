<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Regex;

class UserController extends AbstractController
{

    // Route pour récupérer la liste des utilisateurs
    #[Route('/api/user/list', name: 'app_api_user',methods: ['GET'])]
    public function index(UserRepository $userRepository): Response

    {
        // On récupère la liste des utilisateurs
        $user = $userRepository->findAll();
        
        // On retourne la liste des utilisateurs
        return $this->json($user,200,[],['groups' => 'get_user']);

    }

    // Route pour afficher un utilisateur spécifique
    #[Route('/api/user/show/{id}', name: 'app_api_user_show', methods: ['GET'])]
    public function show(UserRepository $userRepository, $id): Response

    {
        // On récupère l'utilisateur à afficher
        $user = $userRepository->find($id);

        // On retourne l'utilisateur
        return $this->json($user,200,[],['groups' => 'get_user'] );
    }

    // Route pour créer un nouvel utilisateur
    #[Route('/api/user/create', name: 'app_api_user_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserPasswordHasherInterface $userPassword): Response
    {
        
        //ici on récupère l'objet en base
        $content = $request->getContent();
        $user = $serializer->deserialize($content, User::class, 'json');


        // Vérification si le mot de passe respecte la regex
        $password = $user->getPassword();

        // Regex pour vérifier si le mot de passe contient au moins 6 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            return $this->json(
                ['message' => 'Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'],
                400
            );
        }

        // Vérification si l'email est déjà utilisé
        $email = $user->getEmail();

        // On récupère l'email en BDD
        $userEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        
        // Si l'email est déjà utilisé on retourne un message d'erreur
        if ($userEmail) {
            return $this->json(
                ['message' => 'Cet email est déjà utilisé.'],
                400
            );
        }

        // Si toute les condition sont valide on hash le mot de passe et on persist et flush en BDD
        $user->setPassword($userPassword->hashPassword($user, $user->getPassword()));

        // On persiste le nouvel utilisateur
        $entityManager->persist($user);

        // On enregistre le nouvel utilisateur
        $entityManager->flush();

        // On retourne le nouvel utilisateur
        return $this->json($user,201,[],['groups' => 'get_user']);
        
    }


    

    #[Route('/api/user/update/{id}', name: 'app_api_user_update', methods: ['PUT'])]
    public function update(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id,UserPasswordHasherInterface $userPassword): Response
    {
        $content = $request->getContent();
        //ici on récupère l'objet en base
        $user = $userRepository->find($id);
        $user = $serializer->deserialize($content, User::class, 'json',['object_to_populate' => $user]);


        // Vérification si l'email est déjà utilisé
        $email = $user->getEmail();

        // On récupère l'email en BDD
         $userEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

         // Si l'email est déjà utilisé on retourne un message d'erreur
         if ($userEmail) {return $this->json(['message' => 'Cet email est déjà utilisé.'],400);}


        // Vérification si le mot de passe respecte la regex
        $password = $user->getPassword();
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) 
        
        {  // Si le mot de passe ne respecte pas la regex on retourne un message d'erreur
            return $this->json(['message' => 'Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'],400);
        }

        // Si toute les condition sont valide on hash le mot de passe et on persist et flush en BDD
        $user->setPassword($userPassword->hashPassword($user, $user->getPassword()));

        //ici pas besoin de persist car l'objet est déjà en base
        $entityManager->flush();

        return $this->json($user,200,[],['groups' => 'get_user']);
    }


    // Route pour supprimer un utilisateur
    #[Route('/api/user/delete/{id}', name: 'app_api_user_delete', methods: ['DELETE'])]
    public function delete(UserRepository $userRepository, EntityManagerInterface $entityManager, $id): Response
    {
        // On récupère l'utilisateur à supprimer
        $user = $userRepository->find($id);

        // On supprime l'utilisateur
        $entityManager->remove($user);

        // On enregistre la suppression
        $entityManager->flush();

        // On retourne une réponse vide
        return $this->json(null,204);
    }
}
