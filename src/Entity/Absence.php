<?php

// On dit dans quelle "zone" du site se trouve cette entité
namespace App\Entity;

// On importe des annotations et classes nécessaires de Doctrine
use App\Repository\AbsenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// On déclare l'entité avec des annotations Doctrine
#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Absence
{
    // Identifiant auto-incrémenté de l'absence
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_absence'])]
    private ?int $id = null;

    // Date de début de l'absence
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    #[Groups(['get_absence'])]
    private ?\DateTimeInterface $startDate = null;

    // Date de fin de l'absence
    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    #[Groups(['get_absence'])]
    private ?\DateTimeInterface $endDate = null;

    // Commentaire optionnel pour l'absence
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['get_absence'])]
    private ?string $comment = null;

    // Relation ManyToOne avec l'entité Child (un enfant peut avoir plusieurs absences)
    #[ORM\ManyToOne(inversedBy: 'absences', cascade:["persist"])]
    #[Groups(['get_absence'])]
    private ?Child $child = null;

    // Méthode pour récupérer l'identifiant de l'absence
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer la date de début de l'absence
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    // Méthode pour définir la date de début de l'absence
    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;
        return $this;
    }

    // Méthode pour récupérer la date de fin de l'absence
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    // Méthode pour définir la date de fin de l'absence
    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }

    // Méthode pour récupérer le commentaire de l'absence
    public function getComment(): ?string
    {
        return $this->comment;
    }

    // Méthode pour définir le commentaire de l'absence
    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    // Méthode pour récupérer l'entité Child liée à cette absence
    public function getChild(): ?Child
    {
        return $this->child;
    }

    // Méthode pour définir l'entité Child liée à cette absence
    public function setChild(?Child $child): static
    {
        $this->child = $child;
        return $this;
    }
}

