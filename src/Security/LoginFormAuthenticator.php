<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    // La route de connexion (à utiliser dans getLoginUrl())
    public const LOGIN_ROUTE = 'app_login';

    // Injection de dépendance pour le générateur d'URL Symfony
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    // Méthode appelée lors de la tentative d'authentification
    public function authenticate(Request $request): Passport
    {
        // Récupération de l'email depuis la requête
        $email = $request->request->get('email', '');

        // Stockage de l'email dans la session pour l'afficher dans le champ de formulaire
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        // Création d'un objet Passport pour l'authentification
        return new Passport(
            // Badge d'utilisateur basé sur l'email
            new UserBadge($email),
            // Badge de crédentiaux de mot de passe
            new PasswordCredentials($request->request->get('password', '')),
            // Badges supplémentaires (CSRF Token et RememberMe)
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    // Méthode appelée en cas de succès de l'authentification
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Récupération du chemin cible, s'il existe, et redirection vers celui-ci
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Par exemple, redirection vers la page d'inscription
        return new RedirectResponse($this->urlGenerator->generate('app_back_backoffice'));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    // Méthode pour obtenir l'URL de connexion
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
