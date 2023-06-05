<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
    
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
    
            $user = $entityManager->getRepository(User::class)->findOneBy([
                'email' => $email,
            ]);
    
            if (!$user) {
                $this->addFlash('danger', 'Utilisateur non trouvé');
            }
        }
    
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user ?? null, // Pass the user variable to the template
        ]);
    }
    


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        $response = new RedirectResponse($this->generateUrl('app_home_page'));
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
