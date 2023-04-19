<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
        public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
        {
            // création de la contrainte de validation
            $piegeConstraint = new Callback(function ($value, ExecutionContextInterface $context) {
                if (!empty($value)) {
                    $context->buildViolation('Ce champ ne doit pas être rempli.')
                        ->addViolation();
                }
            });
            $message = new Message();
            $form = $this->createForm(ContactType::class, $message);
        
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $contact =$form->getData();

                $entityManager->persist($contact);
                $entityManager->flush();
        
                // Envoyer l'email
                $email = (new Email())
                    ->from($contact->getEmail())
                    ->to('raniderradj2@gmail.com')
                    ->subject($contact->getSubject())
                    ->html($this->renderView('emails/contact.html.twig', ['message' => $message]));
        
                $mailer->send($email);
                
                $this->addFlash(
                    'success',
                    'Votre demande à été envoyé avec succès !'
                );
        
                return $this->redirectToRoute('app_contact');
            }
        
            return $this->render('contact/index.html.twig', [
                'controller_name' => 'ContactController',
                'message'=>$message,
                'form' => $form->createView(),
              
            ]);
        }
}