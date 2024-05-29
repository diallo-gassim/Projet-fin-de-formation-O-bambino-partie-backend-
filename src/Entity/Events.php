<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Entity(repositoryClass: EventsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Events
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Titre de l'événement
    #[ORM\Column(length: 600)]
    // Les annotations "Groups" définissent les groupes de sérialisation
    #[Groups(['get_events'])]
    private ?string $futureEvent = null;

    // Méthode pour récupérer l'identifiant de l'événement
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer le titre de l'événement
    public function getFutureEvent(): ?string
    {
        return $this->futureEvent;
    }

    // Méthode pour définir le titre de l'événement
    public function setFutureEvent(string $futureEvent): static
    {
        $this->futureEvent = $futureEvent;

        return $this;
    }
}
