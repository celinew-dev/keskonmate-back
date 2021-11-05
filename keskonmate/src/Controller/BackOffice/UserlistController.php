<?php

namespace App\Controller\BackOffice;

use App\Entity\User;
use App\Entity\UserList;
use App\Form\UserlistType;
use App\Repository\UserListRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/userlists", name="backoffice_userlist_") 
 * @IsGranted("ROLE_ADMIN")
 */
class UserlistController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(UserListRepository $userlistRepository): Response
    {
        return $this->render('backoffice/userlist/browse.html.twig', [
            'userlist_list' => $userlistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/read/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function read(Request $request, $id, UserListRepository $userlistRepository): Response
    {       
        $userlist = $userlistRepository->find($id); 

        $userlistForm = $this->createForm(UserlistType::class, $userlist, [
            'disabled' => 'disabled'
        ]);

        return $this->render('backoffice/userlist/read.html.twig', [
            'userlist_form' => $userlistForm->createView(),
            'userlist' => $userlistForm,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, UserList $userlist): Response
    {
        $userlistForm = $this->createForm(UserlistType::class, $userlist);

        $userlistForm
            ->remove('createdAt')
            ->remove('updatedAt');

        $userlistForm->handleRequest($request);

        if ($userlistForm->isSubmitted() && $userlistForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $userlist->setUpdatedAt(new DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success', "La liste `{$userlist->getId()}` a été mis à jour");

            return $this->redirectToRoute('backoffice_userlist_browse');
        }

        return $this->render('backoffice/userlist/add.html.twig', [
            'userlist_form' => $userlistForm->createView(),
            'userlist' => $userlist,
            'page' => 'edit',
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userlist = new Userlist();
        
        $userlistForm = $this->createForm(UserlistType::class, $userlist);
        
        $userlistForm
            ->remove('createdAt')
            ->remove('updatedAt');

        $userlistForm->handleRequest($request);
        
        if ($userlistForm->isSubmitted() && $userlistForm->isValid()) {
          
            $entityManager = $this->getDoctrine()->getManager();  
            $entityManager->persist($userlist);
            $userlist->setCreatedAt(new DateTimeImmutable());
            $entityManager->flush();

            // pour opquast 
            $this->addFlash('success', "La liste '{$userlist->getId()}' a été créé");

            // redirection
            return $this->redirectToRoute('backoffice_userlist_browse');
        }

        return $this->render('backoffice/userlist/add.html.twig', [
            'userlist_form' => $userlistForm->createView(),
            'page' => 'create',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function delete(UserList $userlist, EntityManagerInterface $entityManager): Response
    {
        $this->addFlash('success', "La liste '{$userlist->getId()}' a été effacée");

        $entityManager->remove($userlist);
        $entityManager->flush();

        return $this->redirectToRoute('backoffice_userlist_browse');
    }
}
