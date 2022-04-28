<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact')]
    public function contactForm(Request $request, MailerInterface $mailerInterface): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
           $data = $form->getData();
        
           $email=$data['email'];
           $object=$data['object'];
           $text = $data['text'];
           $emailObject = (new Email())

          ->from($email)
            ->to('localhost@localhost.fr')
            ->subject($object)
            ->text($text);

            $mailerInterface->send($emailObject);
        }


        return $this->render('contact/index.html.twig',
         [
            'form' => $form->createView(),
            ]);
    }
}
