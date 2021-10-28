<?php

namespace App\Controller\Api\v1;

use App\Repository\UserListRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/v1/userlists", name="api_v1_userlists_")
 */
class UserlistController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(UserListRepository $userlistRepository): Response
    {
        $allUserlists = $userlistRepository->findAll();
        
        return $this->json($allUserlists, Response::HTTP_OK, [], ['groups' => 'api_userlists_browse']);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(int $id, UserListRepository $userListRepository): Response
    {
        $userList = $userListRepository->find($id);

        return $this->json($userList, Response::HTTP_OK, [], ['groups' => 'api_userlists_read']);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function edit(int $id, UserListRepository $userListRepository, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $actor = $userListRepository->find($id);

        $jsonContent = $request->getContent();

        $serializer->deserialize($jsonContent, Actor::class, 'json');

        $entityManager->persist($actor);
        $entityManager->flush();

        return $this->read($id, $userListRepository);
    }
}
