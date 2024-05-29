<?php

namespace App\Controller\Api;


use App\Entity\User;
use App\Entity\Child;
use App\Repository\UserRepository;
use App\Repository\ChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChildController extends AbstractController
{

    #[Route('/api/child/list', name: 'app_api_child', methods: ['GET'])]
    public function index(ChildRepository $childRepository): Response
    {

        // On récupère la liste des enfants
        $child = $childRepository->findAll();
        
        // On retourne la liste des enfants
        return $this->json($child,200, [], ['groups' => 'get_child']);   
    }


    #[Route('/api/child/show/{id}', name: 'app_api_child_show', methods: ['GET'])]
    public function show(ChildRepository $childRepository, $id): Response
    {
        // On récupère l'enfant à afficher
        $child = $childRepository->find($id);

        // On retourne l'enfant
        return $this->json($child, 200, [], ['groups' => 'get_child']);   
    }


    #[Route('/api/child', name: 'app_api_child_create', methods: ['POST'])]
    public function create(Request $request, ChildRepository $childRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent(); 

        // On désérialise le contenu de la requête
        $child = $serializer->deserialize($content, Child::class, 'json');

        // On persiste l'enfant
        $entityManager->persist($child);

        // On enregistre l'enfant
        $entityManager->flush();

        // On retourne l'enfant créé
        return $this->json($child, 201, [], ['groups' => 'get_child']);  
    }


    #[Route('/api/child/update/{id}', name: 'app_api_child_update', methods: ['PUT'])]
    public function update(Request $request, ChildRepository $childRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id): Response
    {
        // On récupère le contenu de la requête
        $content = $request->getContent(); 

        // On récupère l'enfant à mettre à jour
        $child = $childRepository->find($id);

        // On désérialise le contenu de la requête
        $child = $serializer->deserialize($content, Child::class, 'json', ['object_to_populate' => $child]);
       
        // On met à jour l'enfant
        $entityManager->flush();

        // On retourne l'enfant mis à jour
        return $this->json( $child, 200, [], ['groups' => 'get_child']);  
    }

    
    #[Route('/api/child/delete/{id}', name: 'app_api_child_delete', methods: ['DELETE'])]
    public function delete(ChildRepository $childRepository, EntityManagerInterface $entityManager, $id): Response
    {
        // On récupère l'enfant à supprimer
        $child = $childRepository->find($id);

        // On supprime l'enfant
        $entityManager->remove($child);

        // On enregistre l'enfant
        $entityManager->flush();

        // On retourne l'enfant supprimé
        return $this->json(null, 204);  
    }
    
}
