<?php

namespace App\Controller\Back;

use App\Entity\Events;
use App\Form\EventsType;
use App\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/back/future/events')]
class FutureEventsController extends AbstractController
{
    // Route pour récupérer la liste des événements
    #[Route('/', name: 'app_back_future_events_index', methods: ['GET'])]
    
    public function index(EventsRepository $eventsRepository): Response
    {
        return $this->render('back/future_events/index.html.twig', [
            'events' => $eventsRepository->findAll(),
        ]);
    }

    // Route pour créer un nouvel événement
    #[Route('/new', name: 'app_back_future_events_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création du formulaire
        $event = new Events();
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            // Redirection vers la liste des événements
            return $this->redirectToRoute('app_back_future_events_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire
        return $this->render('back/future_events/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    // Route pour afficher un événement spécifique
    #[Route('/{id}', name: 'app_back_future_events_show', methods: ['GET'])]

    public function show(Events $event): Response
    {
        return $this->render('back/future_events/show.html.twig', [
            'event' => $event,
        ]);
    }

    // Route pour mettre à jour un événement existant
    #[Route('/{id}/edit', name: 'app_back_future_events_edit', methods: ['GET', 'POST'])]

    public function edit(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {   
        // Création du formulaire
        $form = $this->createForm(EventsType::class, $event);
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirection vers la liste des événements
            return $this->redirectToRoute('app_back_future_events_index', [], Response::HTTP_SEE_OTHER);
        }
        // Affichage du formulaire
        return $this->render('back/future_events/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un événement
    #[Route('/{id}', name: 'app_back_future_events_delete', methods: ['POST'])]

    public function delete(Request $request, Events $event, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }
        // Redirection vers la liste des événements
        return $this->redirectToRoute('app_back_future_events_index', [], Response::HTTP_SEE_OTHER);
    }
}
