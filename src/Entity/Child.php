<?php

namespace App\Entity;

use App\Repository\ChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// Définition de l'entité Child avec des annotations ORM pour définir son mapping
#[ORM\Entity(repositoryClass: ChildRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Child
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_child', 'get_report'])]
    private ?int $id = null;

    // Prénom de l'enfant
    #[ORM\Column(length: 100)]
    #[Groups(['get_child', 'get_absence', 'get_report'])]
    private ?string $firstname = null;

    // Nom de famille de l'enfant
    #[ORM\Column(length: 100)]
    #[Groups(['get_child', 'get_absence', 'get_report'])]
    private ?string $lastname = null;

    // Date de naissance de l'enfant
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_child'])]
    private ?\DateTimeInterface $birthday = null;

    // Genre de l'enfant
    #[ORM\Column(length: 50)]
    #[Groups(['get_child'])]
    private ?string $gender = null;

    // Régime alimentaire de l'enfant
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_child'])]
    private ?string $diet = null;

    // Relation ManyToOne avec l'entité User (un enfant peut avoir un seul parent)
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "children")]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_child'])]
    private ?User $user = null;

    // Relation OneToMany avec l'entité Absence (un enfant peut avoir plusieurs absences)
    #[ORM\OneToMany(mappedBy: 'child', targetEntity: Absence::class, orphanRemoval: true)]
    private Collection $absences;

    // Relation OneToMany avec l'entité Report (un enfant peut avoir plusieurs rapports)
    #[ORM\OneToMany(mappedBy: 'child_report', targetEntity: Report::class)]
    private Collection $reports;

    // Relation OneToMany avec l'entité User (un enfant peut avoir plusieurs utilisateurs)
    #[ORM\OneToMany(mappedBy: 'childUser', targetEntity: User::class)]
    private Collection $users;

    // Constructeur pour initialiser les collections
    public function __construct()
    {
        $this->absences = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    // Méthode pour récupérer l'identifiant de l'enfant
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour définir l'identifiant de l'enfant
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    // Méthode pour définir le prénom de l'enfant
    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    // Méthode pour récupérer le nom de famille de l'enfant
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    // Méthode pour définir le nom de famille de l'enfant
    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    // Méthode pour récupérer la date de naissance de l'enfant
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    // Méthode pour définir la date de naissance de l'enfant
    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;
        return $this;
    }

    // Méthode pour récupérer le genre de l'enfant
    public function getGender(): ?string
    {
        return $this->gender;
    }

    // Méthode pour définir le genre de l'enfant
    public function setGender(string $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    // Méthode pour récupérer le régime alimentaire de l'enfant
    public function getDiet(): ?string
    {
        return $this->diet;
    }

    // Méthode pour définir le régime alimentaire de l'enfant
    public function setDiet(?string $diet): static
    {
        $this->diet = $diet;
        return $this;
    }

    // Méthode pour récupérer l'entité User associée à l'enfant
    public function getUser(): ?User
    {
        return $this->user;
    }

    // Méthode pour définir l'entité User associée à l'enfant
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    // Méthode pour récupérer les absences associées à l'enfant
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    // Méthode pour ajouter une absence associée à l'enfant
    public function addAbsence(Absence $absence): static
    {

        // Si l'absence n'est pas déjà associée à l'enfant
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setChild($this);
        }

        // On retourne l'objet enfant
        return $this;
    }

    // Méthode pour supprimer une absence associée à l'enfant
    public function removeAbsence(Absence $absence): static
    {
        // Si l'absence est associée à l'enfant
        if ($this->absences->removeElement($absence)) {
            if ($absence->getChild() === $this) {
                $absence->setChild(null);
            }
        }

        // On retourne l'objet enfant
        return $this;
    }

    // Méthode pour récupérer les rapports associés à l'enfant
    public function getReports(): Collection
    {
        // On retourne la collection de rapports
        return $this->reports;
    }

    // Méthode pour ajouter un rapport associé à l'enfant
    public function addReport(Report $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setChildReport($this);
        }

        // On retourne l'objet enfant
        return $this;
    }

    // Méthode pour supprimer un rapport associé à l'enfant
    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            if ($report->getChildReport() === $this) {
                $report->setChildReport(null);
            }
        }

        // On retourne l'objet enfant
        return $this;
    }

    // Méthode pour récupérer les utilisateurs associés à l'enfant
    public function getUsers(): Collection
    {
        // On retourne la collection d'utilisateurs
        return $this->users;
    }

    // Méthode pour ajouter un utilisateur associé à l'enfant
    public function addUser(User $user): static
    {
        // Si l'utilisateur n'est pas déjà associé à l'enfant
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setChildUser($this);
        }

        // On retourne l'objet enfant
        return $this;
    }

    // Méthode pour supprimer un utilisateur associé à l'enfant
    public function removeUser(User $user): static
    {
        // Si l'utilisateur est associé à l'enfant
        if ($this->users->removeElement($user)) {
            if ($user->getChildUser() === $this) {
                $user->setChildUser(null);
            }
        }

        // On retourne l'objet enfant
        return $this;
    }
}
