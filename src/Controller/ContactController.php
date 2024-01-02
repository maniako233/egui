<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route("/contact", name:"app_contact")]
   
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $message = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le message saisi par l'utilisateur
            $message = $form->get('message')->getData();
        }

        return $this->render('app/contact/index.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }

    #[Route("/confirmation-contact", name:"confirmation_contact")]
    public function confirmationContact(): Response
    {
        return $this->render('app/contact/confirmation.html.twig');
    }


    

}