<?php

namespace App\Controller\Api;

use App\Entity\Notice;
use App\Form\NoticeType;
use App\Repository\NoticeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;



class NoticeController extends AbstractController
{
    // Route pour récupérer la liste des annonces
    #[Route('/api/notice/list', name: 'app_api_notice_index', methods: ['GET'])]
    public function index(NoticeRepository $noticeRepository): Response

    {
        // On récupère la liste des annonces
        $notices = $noticeRepository->findAll();

        // On retourne la liste des annonces
        return $this->json($notices,200,[],['groups' => 'get_notice']);

    }




    // Route pour créer une nouvelle annonce
    #[Route('/api/notice/create', name: 'app_api_notice_new', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager,NoticeRepository $noticeRepository,SerializerInterface $serializer ): Response

    {   
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On désérialise le contenu de la requête
        $notice = $serializer->deserialize($content, Notice::class, 'json');

        // On persiste l'annonce
        $entityManager->persist($notice);

        // On enregistre l'annonce
        $entityManager->flush();

        // On retourne l'annonce créée
        return $this->json($notice,201,[],['groups' => 'get_notice']);

    }





    // Route pour afficher une annonce spécifique
    #[Route('/api/notice/show/{id}', name: 'app_api_notice_show', methods: ['GET'])]
    public function show( NoticeRepository $noticeRepository, $id): Response

    {
        $notice = $noticeRepository->find($id);

        return $this->json($notice,200,[],['groups' => 'get_notice']);

    }


    // Route pour mettre à jour une annonce existante
    #[Route('/api/notice/update/{id}', name: 'app_api_notice_edit', methods: ['PUT'])]
    public function update(Request $request, NoticeRepository $noticeRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response

    {
        // On récupère le contenu de la requête
        $content = $request->getContent();

        // On récupère l'annonce à mettre à jour
        $notice = $noticeRepository->find($id);

        // On met à jour l'annonce
        $serializer->deserialize($content, Notice::class, 'json', ['object_to_populate' => $notice]);

        // On enregistre l'annonce
        $entityManager->flush();

        // On retourne l'annonce mise à jour
        return $this->json($notice,200,[],['groups' => 'get_notice']);

    }



    // Route pour supprimer une annonce
    #[Route('/api/notice/delete/{id}', name: 'app_api_notice_delete', methods: ['DELETE'])]
    public function delete(NoticeRepository $noticeRepository, EntityManagerInterface $entityManager, $id): Response

    {
        // On récupère l'annonce à supprimer
        $notice = $noticeRepository->find($id);

        // On supprime l'annonce
        $entityManager->remove($notice);

        // On enregistre la suppression
        $entityManager->flush();

         // On retourne l'annonce supprimée   
        return $this->json(null,204);
        
    }
}
