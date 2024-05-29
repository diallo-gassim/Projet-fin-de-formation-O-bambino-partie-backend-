<?php

namespace App\Controller\Api;

use App\Entity\EventCalendar;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EventCalendarRepository;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventCalendarController extends AbstractController
{

    // Route pour récupérer la liste des événements
    #[Route('/api/event/calendar', name: 'app_api_event_calendar')]
    public function index(EventCalendarRepository $eventCalendarRepository): Response
    {
        // On récupère la liste des événements
        $event = $eventCalendarRepository->findAll();

        // On retourne la liste des événements
        return $this->json($event,200,[],['groups' => 'get_event']);
        
    }

    // Route pour afficher un événement spécifique
    #[Route('/api/event/calendar/show/{id}', name: 'app_api_event_calendar_show', methods:['GET'])]
    public function show(EventCalendarRepository $eventCalendarRepository, $id): Response
    {
        // On récupère l'événement à afficher
        $event = $eventCalendarRepository->find($id);

        // On retourne l'événement
        return $this->json($event,200,[],['groups' => 'get_event']);
    }

    // Route pour créer un nouvel événement
    #[Route('/api/event/calendar/create', name: 'app_api_event_calendar_create', methods:['GET', 'POST'])]
    public function create(Request $request, EventCalendarRepository $eventCalendarRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On désérialise le contenu de la requête
        $event = $serializer->deserialize($content, EventCalendar::class, 'json');

        // On persiste l'événement
        $entityManager->persist($event);

        // On enregistre l'événement
        $entityManager->flush();

        // On retourne l'événement créé
        return $this->json($event,201,[],['groups' => 'get_event']);
    }

    // Route pour mettre à jour un événement existant
    #[Route('/api/event/calendar/update/{id}', name: 'app_api_event_calendar_update', methods:['PUT'])]
    public function update(Request $request, EventCalendarRepository $eventCalendarRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On récupère l'événement à mettre à jour
        $event = $eventCalendarRepository->find($id);

        // On désérialise le contenu de la requête
        $event=$serializer->deserialize($content, EventCalendar::class, 'json', ['object_to_populate' => $event]);

       // On enregistre l'événement
        $entityManager->flush();

        // On retourne l'événement mis à jour
        return $this->json($event, 200,[],['groups' => 'get_event']);
    }

    // Route pour supprimer un événement
    #[Route('/api/event/calendar/delete/{id}', name: 'app_api_event_calendar_delete', methods:['DELETE'])]
    public function delete(EventCalendarRepository $eventCalendarRepository, EntityManagerInterface $entityManager, $id): Response
    {
        // On récupère l'événement à supprimer
        $event = $eventCalendarRepository->find($id);

        // On supprime l'événement
        $entityManager->remove($event);

        // On enregistre l'événement
        $entityManager->flush();

        // On retourne une réponse vide
        return $this->json(null,204);
    }
}

