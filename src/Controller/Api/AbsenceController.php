<?php

namespace App\Controller\Api;

use App\Entity\Absence;
use App\Repository\AbsenceRepository;
use App\Repository\ChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbsenceController extends AbstractController
{
    // Route pour récupérer la liste des absences
    #[Route('/api/absence/list', name: 'app_api_absence', methods: ['GET'])]
    public function index(AbsenceRepository $absenceRepository): Response
    {
        // On récupère la liste des absences
        $absence = $absenceRepository->findAll();
        
        // On retourne la liste des absences
        return $this->json($absence,200,[],['groups' => 'get_absence']);
    }

    // Route pour afficher une absence spécifique
    #[Route('/api/absence/show/{id}', name: 'app_api_absence_show', methods: ['GET'])]
    public function show(AbsenceRepository $absenceRepository, $id): Response
    {
        // On récupère l'absence à afficher
        $absence = $absenceRepository->find($id);

        // On retourne l'absence
        return $this->json($absence,200,[],['groups' => 'get_absence']);
    }



    // Route pour créer une nouvelle absence
    #[Route('/api/absence/create', name: 'app_api_absence_create', methods: ["POST"])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ChildRepository $childRepository): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On désérialise le contenu de la requête
        $contentArray = json_decode($content,true);

        // On récupère l'enfant associé à l'absence
        $child = $childRepository->find($contentArray['children']);

        // On désérialise l'absence
        $absence = $serializer->deserialize($content, Absence::class, 'json');

        // On associe l'enfant à l'absence
        $absence->setChild($child);

        // On persiste l'absence
        $entityManager->persist($absence);

        // On enregistre l'absence
        $entityManager->flush();

        // On retourne l'absence créée
        return $this->json($absence,201,[],['groups' => 'get_absence']);
    }

    // Route pour mettre à jour une absence existante
    #[Route('/api/absence/update/{id}', name: 'app_api_absence_update', methods: ['PUT'])]
    public function update(Request $request, AbsenceRepository $absenceRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On récupère l'absence à mettre à jour
        $absence = $absenceRepository->find($id);

        // On met à jour l'absence
        $absence = $serializer->deserialize($content, Absence::class, 'json',['object_to_populate' => $absence]);
        
        // On enregistre l'absence
        $entityManager->flush();

        // On retourne l'absence mise à jour
        return $this->json($absence,200, [],['groups' => 'get_absence']);
    }

    // Route pour supprimer une absence
    #[Route('/api/absence/delete/{id}', name: 'app_api_absence_delete', methods: ['DELETE'])]
    public function delete(AbsenceRepository $absenceRepository, EntityManagerInterface $entityManager, $id): Response
    {
        // On récupère l'absence à supprimer
        $absence = $absenceRepository->find($id);

        // On supprime l'absence
        $entityManager->remove($absence);

        // On enregistre l'absence
        $entityManager->flush();

        // On retourne l'absence supprimée
        return $this->json(null,204);
    }
}
