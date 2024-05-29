<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MailController extends AbstractController
{
    // Route pour envoyer un mail
    #[Route('/mail', name: 'app_mail')]

    // Méthode index() pour envoyer un mail
    public function index(MailerService $mailerService): Response
    {
        // Appel de la méthode sendWelcomeEmail() du service MailerService
        $mailerService->sendWelcomeEmail();

        // Affichage de la page mail/index.html.twig
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);

    }
}
