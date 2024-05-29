<?php

namespace App\Controller\Back;

// On importe des outils nécessaires de Symfony
use App\Entity\Report;
use App\Form\ReportType;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// On déclare la classe du contrôleur qui étend une classe de base de Symfony
#[Route('/back/report')]
class ReportController extends AbstractController
{
    // Route pour afficher la liste des rapports (méthode GET)
    #[Route('/', name: 'app_back_report_index', methods: ['GET'])]
    public function index(ReportRepository $reportRepository): Response
    {
        // Récupération de tous les rapports depuis le repository
        return $this->render('back/report/index.html.twig', [
            'reports' => $reportRepository->findAll(),
        ]);
    }

    // Route pour créer un nouveau rapport (méthodes GET et POST)
    #[Route('/new', name: 'app_back_report_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de la classe Report
        $report = new Report();
        // Création d'un formulaire associé à l'entité Report
        $form = $this->createForm(ReportType::class, $report);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Persistance de l'objet Report en base de données
            $entityManager->persist($report);
            $entityManager->flush();

            // Redirection vers la liste des rapports après la création
            return $this->redirectToRoute('app_back_report_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/report/new.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    // Route pour afficher les détails d'un rapport (méthode GET)
    #[Route('/{id}', name: 'app_back_report_show', methods: ['GET'])]
    public function show(Report $report): Response
    {
        // Affichage des détails du rapport dans le template
        return $this->render('back/report/show.html.twig', [
            'report' => $report,
        ]);
    }

    // Route pour éditer un rapport existant (méthodes GET et POST)
    #[Route('/{id}/edit', name: 'app_back_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Report $report, EntityManagerInterface $entityManager): Response
    {
        // Création d'un formulaire pré-rempli avec les données du rapport
        $form = $this->createForm(ReportType::class, $report);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la soumission du formulaire et de sa validité
        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour du rapport en base de données
            $entityManager->flush();

            // Redirection vers la liste des rapports après la modification
            return $this->redirectToRoute('app_back_report_index', [], Response::HTTP_SEE_OTHER);
        }

        // Affichage du formulaire et des données associées dans le template
        return $this->render('back/report/edit.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    // Route pour supprimer un rapport (méthode POST)
    #[Route('/{id}', name: 'app_back_report_delete', methods: ['POST'])]
    public function delete(Request $request, Report $report, EntityManagerInterface $entityManager): Response
    {
        // Vérification du jeton CSRF pour éviter les attaques de type Cross-Site Request Forgery(https://docs.djangoproject.com/fr/5.0/ref/csrf/)
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            // Suppression du rapport en base de données
            $entityManager->remove($report);
            $entityManager->flush();
        }

        // Redirection vers la liste des rapports après la suppression
        return $this->redirectToRoute('app_back_report_index', [], Response::HTTP_SEE_OTHER);
    }
}