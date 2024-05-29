<?php

namespace App\Controller;



// On importe des outils nécessaires de Symfony
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
class RegistrationController extends AbstractController
{
    // Route pour afficher le formulaire d'inscription (méthode GET)
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de la classe User
        $user = new User();
        // Création d'un formulaire associé à l'entité User
        $form = $this->createForm(RegistrationFormType::class, $user);


        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {


            // Encodage du mot de passe en utilisant le service UserPasswordHasherInterface (dans les "use")
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('Password')->getData()
                )
            );

            
            // Persistance de l'objet User en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Authentification de l'utilisateur après l'inscription
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        // Affichage du formulaire d'inscription dans le template
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

