<?php

namespace App\Controller\Back;

use App\Entity\EventCalendar;
use App\Form\EventCalendarType;
use App\Repository\EventCalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/back/event/calendar')]
class EventCalendarController extends AbstractController


{
    // Route pour afficher la liste des événements du calendrier (méthode GET)
    #[Route('/', name: 'app_back_event_calendar_index', methods: ['GET'])]
    public function index(EventCalendarRepository $eventCalendarRepository): Response
    {
        return $this->render('back/event_calendar/index.html.twig', [
            'event_calendars' => $eventCalendarRepository->findAll(),
        ]);
    }

    // Route pour créer un nouvel événement du calendrier (méthodes GET et POST)
    #[Route('/new', name: 'app_back_event_calendar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $eventCalendar = new EventCalendar();
        $form = $this->createForm(EventCalendarType::class, $eventCalendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventCalendar);
            $entityManager->flush();

            return $this->redirectToRoute('app_back_event_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/event_calendar/new.html.twig', [
            'event_calendar' => $eventCalendar,
            'form' => $form,
        ]);

    }

    // Route pour afficher un événement spécifique du calendrier (méthode GET)
    #[Route('/{id}', name: 'app_back_event_calendar_show', methods: ['GET'])]
    public function show(EventCalendar $eventCalendar): Response
    {
        return $this->render('back/event_calendar/show.html.twig', [
            'event_calendar' => $eventCalendar,
        ]);
    }

    // Route pour modifier un événement spécifique du calendrier (méthodes GET et POST)
    #[Route('/{id}/edit', name: 'app_back_event_calendar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventCalendar $eventCalendar, EntityManagerInterface $entityManager): Response

    {
        $form = $this->createForm(EventCalendarType::class, $eventCalendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_back_event_calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/event_calendar/edit.html.twig', [
            'event_calendar' => $eventCalendar,
            'form' => $form,
        ]);

    }

    
    // Route pour supprimer un événement spécifique du calendrier (méthode POST)
    #[Route('/{id}', name: 'app_back_event_calendar_delete', methods: ['POST'])]
    public function delete(Request $request, EventCalendar $eventCalendar, EntityManagerInterface $entityManager): Response

    {
        // Vérification du jeton CSRF
        if ($this->isCsrfTokenValid('delete'.$eventCalendar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventCalendar);
            $entityManager->flush();
        }

        // Redirection vers la liste des événements du calendrier
        return $this->redirectToRoute('app_back_event_calendar_index', [], Response::HTTP_SEE_OTHER);
    }
}
