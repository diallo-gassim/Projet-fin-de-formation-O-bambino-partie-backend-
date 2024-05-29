<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventCalendarRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventCalendarRepository::class)]
class EventCalendar
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    // Les annotations "Groups" définissent les groupes de sérialisation
    #[Groups(['get_event'])]
    private ?int $id = null;

    // Date de début de l'événement
    #[ORM\Column(type: "datetime")]
    #[Groups(['get_event'])]
    private ?\DateTimeInterface $start = null; 

    // Titre de l'événement
    #[ORM\Column(length: 255)]
    #[Groups(['get_event'])]
    private ?string $title = null; 

    // Date de fin de l'événement
    #[ORM\Column(type: "datetime")]
    #[Groups(['get_event'])]
    private ?\DateTimeInterface $end = null; 

    

    // Méthode pour récupérer l'identifiant de l'événement
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer la date de début de l'événement
    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    // Méthode pour définir la date de début de l'événement
    public function setStart(\DateTimeInterface $start): static
    {
        $this->start = $start;
        return $this;
    }

    // Méthode pour récupérer le titre de l'événement
    public function getTitle(): ?string
    {
        return $this->title;
    }

    // Méthode pour définir le titre de l'événement
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    // Méthode pour récupérer la date de fin de l'événement
    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    // Méthode pour définir la date de fin de l'événement
    public function setEnd(\DateTimeInterface $end): static
    {
        $this->end = $end;
        return $this;
    }
}