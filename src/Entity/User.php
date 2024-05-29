<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Définition de l'entité User avec des annotations ORM pour définir son mapping
 * et des contraintes telles que l'unicité de l'email.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_user', 'get_child'])]
    private ?int $id = null;

    // Adresse email unique avec une longueur maximale de 180 caractères
    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['get_user', 'get_child'])]
    private ?string $email = null;

    // Rôles de l'utilisateur
    #[ORM\Column]
    #[Groups(['get_user', 'get_child'])]
    private array $roles = [];

    /**
     * @var string Le mot de passe hashé
     */
    #[ORM\Column]
    #[Groups(['get_user', 'get_child'])]
    private ?string $password = null;

    // Nom de famille de l'utilisateur (optionnel)
    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['get_user', 'get_child'])]
    private ?string $lastname = null;

    // Prénom de l'utilisateur (optionnel)
    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['get_user', 'get_child'])]
    private ?string $firstname = null;

    // Relation ManyToOne avec l'entité Child (un utilisateur est associé à un enfant)
    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Child $childUser = null;


    // Renvoie l'identifiant de l'utilisateur
    public function getId(): ?int
    {
        return $this->id;
    }
    
    // Renvoie l'adresse email de l'utilisateur
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    // Définit l'adresse email de l'utilisateur et renvoie l'instance de l'objet mis à jour
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }
    
    
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    // Renvoie une représentation visuelle de l'identifiant de l'utilisateur
    
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // récupère les rôles de l'utilisateur
        // garantit que chaque utilisateur a au moins le rôle ROLE_USER
        $roles[] = 'ROLE_USER';
    
        // Renvoie la liste des rôles de l'utilisateur
        return array_unique($roles);
    }
    
    // Définit la liste des rôles de l'utilisateur et renvoie l'instance de l'objet mis à jour
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }
    
    
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    // Renvoie le mot de passe haché de l'utilisateur
    public function getPassword(): string
    {
        return $this->password;
    }
    
    // Définit le mot de passe haché de l'utilisateur et renvoie l'instance de l'objet mis à jour
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
    
    
    /**
     * @see UserInterface
     */
    // Efface les informations sensibles liées à l'authentification
    public function eraseCredentials(): void
    {
        // Si vous stockez des données temporaires ou sensibles sur l'utilisateur, effacez-les ici
        // $this->plainPassword = null;
    }
    
    // Renvoie le nom de famille de l'utilisateur
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    
    // Définit le nom de famille de l'utilisateur et renvoie l'instance de l'objet mis à jour
    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }
    
    // Renvoie le prénom de l'utilisateur
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    
    // Définit le prénom de l'utilisateur et renvoie l'instance de l'objet mis à jour
    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }
    
    // Renvoie l'enfant associé à cet utilisateur
    public function getChildUser(): ?Child
    {
        return $this->childUser;
    }
    
    // Définit l'enfant associé à cet utilisateur et renvoie l'instance de l'objet mis à jour
    public function setChildUser(?Child $childUser): static
    {
        $this->childUser = $childUser;
        return $this;
    }
    
}    