<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {

        $form = $this->createForm( ContactType::class);

        $form->handleRequest($request);

              if ($form->isSubmitted() && $form->isValid()) {

                   $contactFormData = $form->getData();

                  $message = (new \Swift_Message($contactFormData['Onderwerp']))
                      ->setFrom($contactFormData['Email'])
                      ->setTo('testschoolmbokanker@gmail.com')
                      ->setBody(
                          $contactFormData['Bericht'], 'text/plain'
                                    )
                            ;

           $mailer->send($message);

           return $this->redirectToRoute('contact');

                   // do something interesting here
               }


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' =>$form->createview(),
        ]);
    }
}
