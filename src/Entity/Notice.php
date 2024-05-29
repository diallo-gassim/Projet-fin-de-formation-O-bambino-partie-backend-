<?php

namespace App\Entity;

use App\Repository\NoticeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NoticeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Notice
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    // Les annotations "Groups" définissent les groupes de sérialisation
    #[Groups(['get_notice'])]
    private ?int $id = null;

    // Commentaire
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['get_notice'])]
    private ?string $comment = null;

    // Auteur
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_notice'])]
    private ?string $authors = null;

    // Méthode pour récupérer l'identifiant de l'avis
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour récupérer le commentaire
    public function getComment(): ?string
    {
        return $this->comment;
    }

    // Méthode pour définir le commentaire
    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    // Méthode pour récupérer l'auteur
    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    // Méthode pour définir l'auteur
    public function setAuthors(?string $authors): static
    {
        $this->authors = $authors;

        return $this;
    }
}
