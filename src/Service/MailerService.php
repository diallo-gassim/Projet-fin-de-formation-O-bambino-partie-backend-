<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MailerService
{

    //  Injection de dépendance pour récupérer l'adresse email de l'administrateur
    public function __construct(
            #[Autowire('%admin_email%')] private string $adminEmail,
            private readonly MailerInterface $mailer,
    ){
       
    }

    //  Méthode pour envoyer un email de bienvenue
    public function sendWelcomeEmail():void
    {
        // Création d'un email de notification
        $email =(new NotificationEmail())

        // Définition de l'objet, de l'expéditeur et du destinataire
        ->subject(subject: 'Welcome')

        // Définition du template HTML de l'email et des variables à passer au template
        ->from($this->adminEmail)

        // Définition du template HTML de l'email et des variables à passer au template
        ->to($this->adminEmail)

        // Définition du template HTML de l'email et des variables à passer au template
        ->htmlTemplate( template: 'emails/welcome.html.twig')

        // Définition du template HTML de l'email et des variables à passer au template
        ->context([
            'username' => 'gassim',
        ]);

        // Envoi de l'email
        $this->mailer->send($email);

     }
} 