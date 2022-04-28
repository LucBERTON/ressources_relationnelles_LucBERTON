<?php

namespace App\Controller;

use App\Entity\Citizen;
use App\Form\CitizenType;
use App\Form\CitizenChoiceType;
use App\Repository\CitizenRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin'), IsGranted('ROLE_ADMIN')]
class AdministrationController extends AbstractController
{
    #[Route('/', name: 'app_admin_index'), IsGranted('ROLE_ADMIN')]
    public function index() : Response
    {
        return $this->render('administration/index.html.twig', []);
    }

    #[Route('/create_citizen', name: 'app_admin_create_citizen')]
    public function createCitizen(Request $request, CitizenRepository $citizenRepository, UserPasswordHasherInterface $encoder): Response
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

        return $this->renderForm('administration/create_citizen.html.twig', [
            'citizen' => $citizen,
            'form' => $form,
        ]);
    }

}
