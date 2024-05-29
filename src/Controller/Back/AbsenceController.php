<?php

//Définition du namespace de la classe 
namespace App\Controller\Back;

//Import des classes nécessaires depuis le framework symfony
use App\Entity\Absence;
use App\Form\AbsenceType;
use App\Repository\AbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


//Définition du chemin de base pour les routes de cette classe
#[Route('/back/absence')]
class AbsenceController extends AbstractController
{
    //Route pour afficher la liste des absences 
    #[Route('/', name: 'app_back_absence_index', methods: ['GET'])]
    public function index(AbsenceRepository $absenceRepository): Response
    {

    //Récupération de la liste des absences depuis la base de données (grâce au repository AbsenceRepository) et affichage de la vue associée (index.html.twig)
        return $this->render('back/absence/index.html.twig', [
            'absences' => $absenceRepository->findAll(),
        ]);
    }

    //Route pour créer une nouvelle absence (méthodes GET et POST pour afficher le formulaire et traiter les données du formulaire)
    #[Route('/new', name: 'app_back_absence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        //Création d'une nouvelle instance de la classe Absence
        $absence = new Absence();
        //Création du formulaire associé à l'entité Absence
        $form = $this->createForm(AbsenceType::class, $absence);
        //Gestion de la soumission du formulaire
        $form->handleRequest($request);

        //Véification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            //Persistance de l'objet Absence dans la base de données
            $entityManager->persist($absence);
            $entityManager->flush();

            //Redirection vers la liste des absences àprès la création de la nouvelle absence
            return $this->redirectToRoute('app_back_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        //Affichage du formulaire et des données associées dans le template
        return $this->render('back/absence/new.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'une absence via l'id (méthode GET)
    #[Route('/{id}', name: 'app_back_absence_show', methods: ['GET'])]
    public function show(Absence $absence): Response
    {
        // Affichage des détails de l'absence dans le template
        return $this->render('back/absence/show.html.twig', [
            'absence' => $absence,
        ]);
    }

    // Route pour éditer(modifier) une absence existante (méthodes GET et POST)
    #[Route('/{id}/edit', name: 'app_back_absence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Absence $absence, EntityManagerInterface $entityManager): Response
    {
        // Création d'un formulaire pré-rempli avec les données de l'absence
        $form = $this->createForm(AbsenceType::class, $absence);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour de l'absence en base de données
            $entityManager->flush();

            // Redirection vers la liste des absences après la modification
            return $this->redirectToRoute('app_back_absence_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/absence/edit.html.twig', [
            'absence' => $absence,
            'form' => $form,
        ]);
    }

    // Route pour supprimer une absence (méthode POST)
    #[Route('/{id}', name: 'app_back_absence_delete', methods: ['POST'])]
    public function delete(Request $request, Absence $absence, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF pour éviter les attaques de type Cross-Site Request Forgery
        if ($this->isCsrfTokenValid('delete'.$absence->getId(), $request->request->get('_token'))) {
            // Suppression de l'absence en base de données
            $entityManager->remove($absence);
            $entityManager->flush();
        }

        // Redirection vers la liste des absences après la suppression
        return $this->redirectToRoute('app_back_absence_index', [], Response::HTTP_SEE_OTHER);
    }
}