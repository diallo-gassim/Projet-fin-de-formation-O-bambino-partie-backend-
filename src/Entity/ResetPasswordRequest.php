<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
   
    
    // utilisez le trait pour implémenter l'interface
    use ResetPasswordRequestTrait;

    // Identifiant auto-incrémenté de la demande de réinitialisation de mot de passe
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Relation ManyToOne avec l'entité User
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Méthode pour récupérer l'identifiant de la demande de réinitialisation de mot de passe
    public function __construct(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

    // Méthode pour récupérer l'identifiant de la demande de réinitialisation de mot de passe
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer l'utilisateur associé à la demande de réinitialisation de mot de passe
    public function getUser(): object
    {
        return $this->user;
    }
}
