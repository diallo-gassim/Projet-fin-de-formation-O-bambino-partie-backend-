<?php


namespace App\Controller;


use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
class SecurityController extends AbstractController
{
    // Route pour afficher le formulaire de connexion (méthode GET)
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupération de l'éventuelle erreur de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupération du dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        

        // Affichage du formulaire de connexion avec les données nécessaires
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        
    }

    // Route pour gérer la déconnexion (méthode GET)
    #[Route(path: '/logout', name: 'app_logout')]

    public function logout(): void

    {
        // Cette méthode peut être laissée vide car elle sera interceptée par la clé de déconnexion du pare-feu.
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

