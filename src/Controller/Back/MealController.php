<?php

namespace App\Controller\Back;

// On importe des outils nécessaires de Symfony
use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\MealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
#[Route('/back/meal')]
class MealController extends AbstractController
{
    // Route pour afficher la liste des repas (méthode GET)
    #[Route('/', name: 'app_back_meal_index', methods: ['GET'])]
    public function index(MealRepository $mealRepository): Response
    {
        // Récupération de tous les repas depuis le repository
        return $this->render('back/meal/index.html.twig', [
            'meals' => $mealRepository->findAll(),
        ]);
    }

    // Route pour créer un nouveau repas (méthodes GET et POST)
    #[Route('/new', name: 'app_back_meal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de la classe Meal
        $meal = new Meal();
        // Création d'un formulaire associé à l'entité Meal
        $form = $this->createForm(MealType::class, $meal);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Persistance de l'objet Meal en base de données
            $entityManager->persist($meal);
            $entityManager->flush();

            // Redirection vers la liste des repas après la création
            return $this->redirectToRoute('app_back_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'un repas (méthode GET)
    #[Route('/{id}', name: 'app_back_meal_show', methods: ['GET'])]
    public function show(Meal $meal): Response
    {
        // Affichage des détails du repas dans le template
        return $this->render('back/meal/show.html.twig', [
            'meal' => $meal,
        ]);
    }

    // Route pour éditer un repas existant (méthodes GET et POST)
    #[Route('/{id}/edit', name: 'app_back_meal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meal $meal, EntityManagerInterface $entityManager): Response
    {
        // Création d'un formulaire pré-rempli avec les données du repas
        $form = $this->createForm(MealType::class, $meal);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour du repas en base de données
            $entityManager->flush();

            // Redirection vers la liste des repas après la modification
            return $this->redirectToRoute('app_back_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un repas (méthode POST)
    #[Route('/{id}', name: 'app_back_meal_delete', methods: ['POST'])]
    public function delete(Request $request, Meal $meal, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF pour éviter les attaques de type Cross-Site Request Forgery (https://docs.djangoproject.com/fr/5.0/ref/csrf/)
        if ($this->isCsrfTokenValid('delete'.$meal->getId(), $request->request->get('_token'))) {
            // Suppression du repas en base de données
            $entityManager->remove($meal);
            $entityManager->flush();
        }

        // Redirection vers la liste des repas après la suppression
        return $this->redirectToRoute('app_back_meal_index', [], Response::HTTP_SEE_OTHER);
    }
}