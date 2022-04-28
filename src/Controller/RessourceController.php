<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\FavoriteRepository;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Citizen;
#[Route('/ressource')]
class RessourceController extends AbstractController
{
    
    #[Route('/', name: 'app_ressource_index', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository, FavoriteRepository $favoriteRepository): Response
    {
        $user = $this->getUser();
       
        $favoriteList = $favoriteRepository->findBy(['citizen' => $user]);

        $ressources = $ressourceRepository->findAll();
        return $this->render('ressource/index.html.twig', [
            'ressources' => $ressources
        ]);
    }

    #[Route('/getFavorite', name: 'app_ressource_get_favorite', methods: ['GET', 'POST'])]
    public function listFavorite(FavoriteRepository $favoriteRepository)
    {
        $user = $this->getUser();

        $favorites = $favoriteRepository->findBy(['citizen' => $user]);
        return new JsonResponse($favorites);
    }

    #[Route('/new', name: 'app_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RessourceRepository $ressourceRepository): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ressourceRepository->add($ressource);
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ressource/new.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(Ressource $ressource): Response
    {
        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, RessourceRepository $ressourceRepository): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ressourceRepository->add($ressource);
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ressource/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, RessourceRepository $ressourceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ressource->getId(), $request->request->get('_token'))) {
            $ressourceRepository->remove($ressource);
        }

        return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/addtofavorite/{id}', name: 'app_ressource_favorite', methods: ['GET'])]
    public function addToFavorite($id, RessourceRepository $ressourceRepository, FavoriteRepository $favoriteRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $citizen = $this->getUser();
        $ressource = $ressourceRepository->find($id);
        $favoriteAlreadyExist = $favoriteRepository->findOneBy(['ressource' => $ressource, 'citizen' => $citizen]);
        if ($favoriteAlreadyExist === null) {
            $favorite = new Favorite();
            $favorite->setRessource($ressource)
                ->setCitizen($citizen);

            $entityManager->persist($favorite);
            $entityManager->flush();

            return new JsonResponse('ok');
        }

        
        $entityManager->remove($favoriteAlreadyExist);
        $entityManager->flush();
        return new JsonResponse('deleted');
    }
}
