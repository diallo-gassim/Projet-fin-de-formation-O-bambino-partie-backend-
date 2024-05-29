<?php

namespace App\Controller\Api;

use App\Entity\Events;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FutureEventsController extends AbstractController
{
    // Route pour récupérer la liste des événements
    #[Route('/api/future/events/list', name: 'app_api_future_events')]
    public function index(EventsRepository $eventsRepository): Response

    {
        // On récupère la liste des événements
        $events = $eventsRepository->findAll();
        
        // On retourne la liste des événements
        return $this->json($events,200, [], ['groups' => 'get_events']);  
        
    }

    // Route pour afficher un événement spécifique
    #[Route('/api/future/events/show/{id}', name: 'app_api_future_events_show', methods: ['GET'])]
    public function show(EventsRepository $eventsRepository, $id): Response
    {

        // On récupère l'événement à afficher
        $events = $eventsRepository->find($id);

        // On retourne l'événement
        return $this->json($events, 200, [], ['groups' => 'get_events']);  

    }

    // Route pour créer un nouvel événement
    #[Route('/api/future/events', name: 'app_api_future_events_create', methods: ['POST'])]
    public function create(Request $request, EventsRepository $eventsRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent(); 

        // On désérialise le contenu de la requête
        $events = $serializer->deserialize($content, Events::class, 'json');

        // On persiste l'événement
        $entityManager->persist($events);

        // On enregistre l'événement
        $entityManager->flush();


        // On retourne l'événement créé
        return $this->json($events, 201, [], ['groups' => 'get_events']);  

    }

    // Route pour mettre à jour un événement existant
    #[Route('/api/future/events/update/{id}', name: 'app_api_future_events_update', methods: ['PUT'])]
    public function update(Request $request, EventsRepository $eventsRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent(); 

        // On récupère l'événement à mettre à jour
        $events = $eventsRepository->find($id);

        // On met à jour l'événement
        $events = $serializer->deserialize($content, Events::class, 'json', ['object_to_populate' => $events]);

        // On enregistre l'événement
        $entityManager->persist($events);

        // On enregistre l'événement
        $entityManager->flush();

        // On retourne l'événement mis à jour
        return $this->json($events, 200, [], ['groups' => 'get_events']);  

    }

    // Route pour supprimer un événement
    #[Route('/api/future/events/delete/{id}', name: 'app_api_future_events_delete', methods: ['DELETE'])]
    public function delete(EventsRepository $eventsRepository, EntityManagerInterface $entityManager, $id): Response
    {
        // On récupère l'événement à supprimer
        $events = $eventsRepository->find($id);

        // On supprime l'événement
        $entityManager->remove($events);

        // On enregistre l'événement
        $entityManager->flush();

        // On retourne l'événement supprimé
        return $this->json($events, 204,);  
        
    }
}
