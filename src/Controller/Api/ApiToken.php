<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ApiToken extends AbstractController
{
    // Définition de la route '/api/secure/test' avec la méthode GET
    #[Route('/api/secure/test', name:'api_login_check_test', methods: ['GET'])]
    public function index(): Response
    {
        // Récupération de l'utilisateur actuellement connecté
        $user = $this->getUser();
        
        // Retourne l'utilisateur au format JSON avec le code de statut 200
        // en utilisant le groupe de sérialisation 'get_user'
        return $this->json($user,200,[],['groups' => 'get_user']);
        
    }
}
