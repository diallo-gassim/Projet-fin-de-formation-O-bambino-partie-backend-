<?php

namespace App\Controller\Api;

use App\Entity\Meal;
use App\Repository\MealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MealController extends AbstractController
{
    // Route pour récupérer la liste des repas
    #[Route('/api/meal/list', name: 'app_api_meal', methods: ['GET'])]
    public function index(MealRepository $mealRepository): Response

    {
        // On récupère la liste des repas
        $meals = $mealRepository->findAll();

        // On retourne la liste des repas
        return $this->json($meals,200,[],['groups' => 'get_meal']);

    }

    // Route pour afficher un repas spécifique
    #[Route('/api/meal/show/{id}', name: 'app_api_meal_show', methods: ['GET'])]
    public function show(MealRepository $mealRepository, $id): Response

    {
        // On récupère le repas à afficher
        $meal = $mealRepository->find($id);

        // On retourne le repas
        return $this->json($meal,200,[],['groups' => 'get_meal']);

    }

    // Route pour créer un nouveau repas
    #[Route('/api/meal/create', name: 'app_api_meal_create', methods: ['POST'])]
    public function create(Request $request, MealRepository $mealRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response

    {

        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On désérialise le contenu de la requête
        $meal = $serializer->deserialize($content, Meal::class, 'json');

        // On persiste le repas
        $entityManager->persist($meal);

        // On enregistre le repas
        $entityManager->flush();


        return $this->json($meal,201,[],['groups' => 'get_meal']);

    }

    // Route pour mettre à jour un repas existant
    #[Route('/api/meal/update/{id}', name: 'app_api_meal_update', methods: ['PUT'])]
    public function update(Request $request, MealRepository $mealRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response

    {

        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On récupère le repas à mettre à jour
        $meal = $mealRepository->find($id);

        // On met à jour le repas
        $serializer->deserialize($content, Meal::class, 'json', ['object_to_populate' => $meal]);

       
        // On enregistre le repas
        $entityManager->flush();

        // On retourne le repas mis à jour
        return $this->json($meal,200,[],['groups' => 'get_meal']);

    }

    // Route pour supprimer un repas
    #[Route('/api/meal/delete/{id}', name: 'app_api_meal_delete', methods: ['DELETE'])]
    public function delete(MealRepository $mealRepository, EntityManagerInterface $entityManager, $id): Response
    
    {
        // On récupère le repas à supprimer
        $meal = $mealRepository->find($id);

        // On supprime le repas
        $entityManager->remove($meal);

        // On enregistre le repas
        $entityManager->flush();

        // On retourne le repas supprimé
        return $this->json(null,204);

    }
}
