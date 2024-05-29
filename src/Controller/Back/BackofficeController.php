<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
class BackofficeController extends AbstractController
{
    // On indique l'adresse (URL) à laquelle ce contrôleur répond
    #[Route('/back/backoffice', name: 'app_back_backoffice')]
    public function index(): Response
    {
        // On renvoie une page HTML en réponse à la demande de l'utilisateur
        return $this->render('back/backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }
}
