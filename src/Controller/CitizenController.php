<?php

namespace App\Controller;

use App\Entity\Citizen;
use App\Form\CitizenType;
use App\Repository\CitizenRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use App\Repository\RessourceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/citizen')]
class CitizenController extends AbstractController
{
    #[Route('/', name: 'app_citizen_index', methods: ['GET'])]
    public function index(CitizenRepository $citizenRepository): Response
    {
        return $this->render('citizen/index.html.twig', [
            'citizens' => $citizenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_citizen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CitizenRepository $citizenRepository, UserPasswordHasherInterface $encoder): Response
    {
        $citizen = new Citizen();
        $form = $this->createForm(CitizenType::class, $citizen);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            // encoding the password
            $citizen->setPassword(
                $encoder->hashPassword(
                    $citizen,
                    $form->get('password')->getData()
                )
            );

            $citizen->setRoles(['ROLE_USER']);

            $citizen->setStatus(true);

            $citizenRepository->add($citizen);
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('citizen/new.html.twig', [
            'citizen' => $citizen,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_citizen_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Citizen $citizen): Response
    {
        return $this->render('citizen/show.html.twig', [
            'citizen' => $citizen,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_citizen_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Citizen $citizen, CitizenRepository $citizenRepository): Response
    {
        $form = $this->createForm(CitizenType::class, $citizen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citizenRepository->add($citizen);
            return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('citizen/edit.html.twig', [
            'citizen' => $citizen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_citizen_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Citizen $citizen, CitizenRepository $citizenRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $citizen->getId(), $request->request->get('_token'))) {
            $citizenRepository->remove($citizen);
        }

        return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/activate', name: 'app_citizen_activate', methods: ['GET','POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function activate(Citizen $citizen, ManagerRegistry $doctrine): Response
    {

        $citizen->setStatus(true);

        $manager = $doctrine->getManager();
        $manager->persist($citizen);
        $manager->flush();

        return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/deactivate', name: 'app_citizen_deactivate', methods: ['GET','POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deactivate(Citizen $citizen, ManagerRegistry $doctrine): Response
    {

        $citizen->setStatus(false);

        $manager = $doctrine->getManager();
        $manager->persist($citizen);
        $manager->flush();

        return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/moderator', name: 'app_citizen_moderator', methods: ['GET','POST'])]
    #[IsGranted('ROLE_SUPERADMIN')]
    public function changeToModerator(Citizen $citizen, ManagerRegistry $doctrine): Response
    {

        $citizen->becomeModerator();

        $manager = $doctrine->getManager();
        $manager->persist($citizen);
        $manager->flush();

        return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/admin', name: 'app_citizen_admin', methods: ['GET','POST'])]
    #[IsGranted('ROLE_SUPERADMIN')]
    public function changeToAdmin(Citizen $citizen, ManagerRegistry $doctrine): Response
    {
        $citizen->becomeAdmin();

        $manager = $doctrine->getManager();
        $manager->persist($citizen);
        $manager->flush();

        return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/superadmin', name: 'app_citizen_superadmin', methods: ['GET','POST'])]
    #[IsGranted('ROLE_SUPERADMIN')]
    public function changeToSuperAdmin(Citizen $citizen, ManagerRegistry $doctrine): Response
    {

        
        $citizen->becomeSuperAdmin();

        $manager = $doctrine->getManager();
        $manager->persist($citizen);
        $manager->flush();

        return $this->redirectToRoute('app_citizen_index', [], Response::HTTP_SEE_OTHER);
    }
}
