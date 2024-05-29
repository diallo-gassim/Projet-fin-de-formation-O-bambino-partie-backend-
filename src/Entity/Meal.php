<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// Définition de l'entité Meal avec des annotations ORM pour définir son mapping
#[ORM\Entity(repositoryClass: MealRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Meal
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_meal'])]
    private ?int $id = null;

    // Entrée du repas
    // Les annotations "Groups" définissent les groupes de sérialisation
    // dans le contexte de l'API, permettant de spécifier quelles données
    // doivent être incluses dans la réponse pour un groupe donné.

    // Par exemple, ici, le groupe "get_meal" indique que les propriétés
    // annotées avec ce groupe seront incluses lors de la sérialisation
    // des objets "Meal" pour l'action de récupération ("GET") de l'API.
    #[ORM\Column(length: 255)]
    #[Groups(['get_meal'])]
    private ?string $starter = null;

    // Plat principal du repas
    #[ORM\Column(length: 255)]
    #[Groups(['get_meal'])]
    private ?string $mainMeal = null;

    // Dessert du repas
    #[ORM\Column(length: 255)]
    #[Groups(['get_meal'])]
    private ?string $dessert = null;

    // Gouter
    #[ORM\Column(length: 255)]
    #[Groups(['get_meal'])]
    private ?string $snack = null;

    // Date du repas
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_meal'])]
    private ?\DateTimeInterface $date = null;
    
    #[ORM\Column(length: 255)]
    #[Groups(['get_meal'])]
    private ?string $WeekDay = null;

    // Référence vers le rapport associé à ce repas
    #[ORM\ManyToOne(inversedBy: 'meals')]
    private ?Report $reportMeal = null;



    // Méthode pour obtenir l'identifiant du repas
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour obtenir l'entrée du repas
    public function getStarter(): ?string
    {
        return $this->starter;
    }

    // Méthode pour définir l'entrée du repas
    public function setStarter(string $starter): static
    {
        $this->starter = $starter;
        return $this;
    }

    // Méthode pour obtenir le plat principal du repas
    public function getMainMeal(): ?string
    {
        return $this->mainMeal;
    }

    // Méthode pour définir le plat principal du repas
    public function setMainMeal(string $mainMeal): static
    {
        $this->mainMeal = $mainMeal;
        return $this;
    }

    // Méthode pour obtenir le dessert du repas
    public function getDessert(): ?string
    {
        return $this->dessert;
    }

    // Méthode pour définir le dessert du repas
    public function setDessert(string $dessert): static
    {
        $this->dessert = $dessert;
        return $this;
    }

    // Méthode pour obtenir l'encas du repas
    public function getSnack(): ?string
    {
        return $this->snack;
    }

    // Méthode pour définir l'encas du repas
    public function setSnack(string $snack): static
    {
        $this->snack = $snack;
        return $this;
    }

    // Méthode pour obtenir la date du repas
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    // Méthode pour définir la date du repas
    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    // Méthode pour obtenir le rapport associé à ce repas
    public function getReportMeal(): ?Report
    {
        return $this->reportMeal;
    }

    // Méthode pour définir le rapport associé à ce repas
    public function setReportMeal(?Report $reportMeal): static
    {
        $this->reportMeal = $reportMeal;
        return $this;
    }

    // Méthode pour obtenir le jour de la semaine
    public function getWeekDay(): ?string
    {
        return $this->WeekDay;
    }

    // Méthode pour définir le jour de la semaine
    public function setWeekDay(string $WeekDay): static
    {
        $this->WeekDay = $WeekDay;

        return $this;
    }
}