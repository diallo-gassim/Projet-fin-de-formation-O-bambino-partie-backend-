<?php

namespace App\Controller\Api;

use App\Entity\Report;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    // Route pour récupérer la liste des rapports
    #[Route('/api/report/list', name: 'app_api_report', methods: ['GET'])]
    public function index(ReportRepository $reportRepository): Response

    {
        // On récupère la liste des rapports
        $report = $reportRepository->findAll();

        // On retourne la liste des rapports
        return $this->json($report,200,[],['groups' => 'get_report']);

    }
    
    // Route pour afficher un rapport spécifique
    #[Route('/api/report/show/{id}', name: 'app_api_report_show', methods: ['GET'])]
    public function show(ReportRepository $reportRepository, $id): Response

    {
        // On récupère le rapport à afficher
        $report = $reportRepository->find($id);

        // On retourne le rapport
        return $this->json($report,200,[],['groups' => 'get_report']);

    }

    // Route pour créer un nouveau rapport
    #[Route('/api/report/create', name: 'app_api_report_create', methods: ['POST'])]
    public function create(Request $request, ReportRepository $reportRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response

    {
        // On récupère le contenu de la requête
        $content = $request->getContent();
        $report = $serializer->deserialize($content, Report::class, 'json');

        // On persiste le rapport
        $entityManager->persist($report);
        // On enregistre le rapport
        $entityManager->flush();

        // On retourne le rapport créé
        return $this->json($report,201,[],['groups' => 'get_report']);

    }

    // Route pour mettre à jour un rapport existant
    #[Route('/api/report/update/{id}', name: 'app_api_report_update', methods: ['PUT'])]
    public function update(Request $request, ReportRepository $reportRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On récupère le rapport à mettre à jour
        $report = $reportRepository->find($id);

        // On met à jour le rapport
        $report = $serializer->deserialize($content, Report::class, 'json',['object_to_populate' => $report]);

       // On enregistre le rapport
        $entityManager->flush();

        // On retourne le rapport mis à jour
        return $this->json($report,200,[],['groups' => 'get_report']);

    }

    
     // Route pour supprimer un rapport
    #[Route('/api/report/delete/{id}', name: 'app_api_report_delete', methods: ['DELETE'])]
    public function delete(ReportRepository $reportRepository, EntityManagerInterface $entityManager, $id): Response

    {
        // On récupère le rapport à supprimer
        $report = $reportRepository->find($id);

        // On supprime le rapport
        $entityManager->remove($report);
        
        // On enregistre la suppression
        $entityManager->flush();

        // On retourne une réponse vide
        return $this->json(null,204, );

    }

    
}
