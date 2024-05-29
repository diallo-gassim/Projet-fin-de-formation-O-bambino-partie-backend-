<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

// Définition de l'entité "Report" avec des annotations ORM pour définir son mapping
// et des annotations "Groups" pour spécifier les groupes de sérialisation.

#[ORM\Entity(repositoryClass: ReportRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Report
{
    // Identifiant unique généré automatiquement
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_report'])]
    private ?int $id = null;

    // Champ optionnel pour stocker un rappel lié au rapport
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_report'])]
    private ?string $reminder = null;

    // Date du rapport, stockée sous forme de DateTime mutable
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_report'])]
    private ?\DateTimeInterface $dateReport = null;

    // Champ pour stocker des informations sur les repas du rapport
    #[ORM\Column(length: 255)]
    #[Groups(['get_report'])]
    private ?string $mealReport = null;

    // Champ pour stocker des informations sur les toilettes du rapport
    #[ORM\Column(length: 255)]
    #[Groups(['get_report'])]
    private ?string $toiletReport = null;

    // Champ pour stocker des informations sur le sommeil du rapport
    #[ORM\Column(length: 255)]
    #[Groups(['get_report'])]
    private ?string $sleepReport = null;

    // Relation ManyToOne avec l'entité "Child", indiquant l'enfant associé à ce rapport
    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[Groups(['get_report'])]
    private ?Child $child_report = null;

    // Relation OneToMany avec l'entité "Meal", indiquant les repas associés à ce rapport
    #[ORM\OneToMany(mappedBy: 'reportMeal', targetEntity: Meal::class)]
    private Collection $meals;

    // Constructeur initialisant la collection de repas
    public function __construct()
    {
        $this->meals = new ArrayCollection();
    }

    // Méthode pour obtenir l'identifiant du rapport
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour obtenir le rappel associé au rapport
    public function getReminder(): ?string
    {
        return $this->reminder;
    }

    // Méthode pour définir le rappel associé au rapport
    public function setReminder(?string $reminder): static
    {
        $this->reminder = $reminder;
        return $this;
    }

    // Méthode pour obtenir la date du rapport
    public function getDateReport(): ?\DateTimeInterface
    {
        return $this->dateReport;
    }

    // Méthode pour définir la date du rapport
    public function setDateReport(\DateTimeInterface $dateReport): static
    {
        $this->dateReport = $dateReport;
        return $this;
    }

    // Méthode pour obtenir les informations sur les repas du rapport
    public function getMealReport(): ?string
    {
        return $this->mealReport;
    }

    // Méthode pour définir les informations sur les repas du rapport
    public function setMealReport(string $mealReport): static
    {
        $this->mealReport = $mealReport;
        return $this;
    }

    // Méthode pour obtenir les informations sur les toilettes du rapport
    public function getToiletReport(): ?string
    {
        return $this->toiletReport;
    }

    // Méthode pour définir les informations sur les toilettes du rapport
    public function setToiletReport(string $toiletReport): static
    {
        $this->toiletReport = $toiletReport;
        return $this;
    }

    // Méthode pour obtenir les informations sur le sommeil du rapport
    public function getSleepReport(): ?string
    {
        return $this->sleepReport;
    }

    // Méthode pour définir les informations sur le sommeil du rapport
    public function setSleepReport(string $sleepReport): static
    {
        $this->sleepReport = $sleepReport;
        return $this;
    }

    // Méthode pour obtenir l'enfant associé au rapport
    public function getChildReport(): ?Child
    {
        return $this->child_report;
    }

    // Méthode pour définir l'enfant associé au rapport
    public function setChildReport(?Child $child_report): static
    {
        $this->child_report = $child_report;
        return $this;
    }

    /**
     * Méthode pour obtenir la collection des repas associés au rapport
     * @return Collection<int, Meal>
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    /**
 * Méthode pour ajouter un repas à la collection des repas du rapport
 * @param Meal $meal
 * @return static
 */
public function addMeal(Meal $meal): static
{
    // Vérifie si le repas n'est pas déjà dans la collection
    if (!$this->meals->contains($meal)) {
        // Ajoute le repas à la collection
        $this->meals->add($meal);
        // Définit le rapport associé au repas
        $meal->setReportMeal($this);
    }

    // Retourne l'objet courant pour permettre les appels chaînés
    return $this;
}

/**
 * Méthode pour supprimer un repas de la collection des repas du rapport
 * @param Meal $meal
 * @return static
 */
public function removeMeal(Meal $meal): static
{
    // Vérifie si le repas est présent dans la collection
    if ($this->meals->removeElement($meal)) {
        // Définit le côté propriétaire à null (sauf s'il a déjà été modifié)
        if ($meal->getReportMeal() === $this) {
            $meal->setReportMeal(null);
        }
    }

    // Retourne l'objet courant pour permettre les appels chaînés
    return $this;
}

}
