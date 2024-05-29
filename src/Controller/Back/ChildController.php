<?php

namespace App\Controller\Back;

// On importe des outils nécessaires de Symfony
use App\Entity\Child;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
#[Route('/back/child')]
class ChildController extends AbstractController
{
    // Route pour afficher la liste des enfants (méthode GET)
    #[Route('/', name: 'app_back_child_index', methods: ['GET'])]
    public function index(ChildRepository $childRepository): Response
    {
        // Récupération de tous les enfants depuis le repository
        return $this->render('back/child/index.html.twig', [
            'children' => $childRepository->findAll(),
        ]);
    }

    // Route pour créer un nouvel enfant (méthodes GET et POST)
    #[Route('/new', name: 'app_back_child_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de la classe Child
        $child = new Child();
        // Création d'un formulaire associé à l'entité Child
        $form = $this->createForm(ChildType::class, $child);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {

            //récuperation de l'objet parent
            $parent = $form->get('user')->getData();

            //Association de l'enfant à son parent
            $child->setUser($parent);
            
            // Persistance de l'objet Child en base de données
            $entityManager->persist($child);
            $entityManager->flush();

            // Redirection vers la liste des enfants après la création
            return $this->redirectToRoute('app_back_child_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/child/new.html.twig', [
            'child' => $child,
            'form' => $form->createView(),
        ]);
    }

    // Route pour afficher les détails d'un enfant (méthode GET)
    #[Route('/{id}', name: 'app_back_child_show', methods: ['GET'])]
    public function show(Child $child): Response
    {
        // Affichage des détails de l'enfant dans le template
        return $this->render('back/child/show.html.twig', [
            'child' => $child,
        ]);
    }

    // Route pour éditer un enfant existant (méthodes GET et POST)
    #[Route('/{id}/edit', name: 'app_back_child_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Child $child, EntityManagerInterface $entityManager): Response
    {
        // Création d'un formulaire pré-rempli avec les données de l'enfant
        $form = $this->createForm(ChildType::class, $child);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour de l'enfant en base de données
            $entityManager->flush();

            // Redirection vers la liste des enfants après la modification
            return $this->redirectToRoute('app_back_child_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/child/edit.html.twig', [
            'child' => $child,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un enfant (méthode POST)
    #[Route('/{id}', name: 'app_back_child_delete', methods: ['POST'])]
    public function delete(Request $request, Child $child, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF pour éviter les attaques de type Cross-Site Request Forgery(https://docs.djangoproject.com/fr/5.0/ref/csrf/)
        if ($this->isCsrfTokenValid('delete'.$child->getId(), $request->request->get('_token'))) {
            // Suppression de l'enfant en base de données
            $entityManager->remove($child);
            $entityManager->flush();
        }

        // Redirection vers la liste des enfants après la suppression
        return $this->redirectToRoute('app_back_child_index', [], Response::HTTP_SEE_OTHER);
    }
}