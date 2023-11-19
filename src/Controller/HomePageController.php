<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class HomePageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        // $injection = "
        // <script>
        //     var body = document.querySelector('body');
        //     body.innerHTML = 'merci de vous connecter à cette page pour continuer'
        // </script>";
        // // Votre code existant pour la page d'accueil (index) ici "injection" => $injection
        return $this->render('home_page/index.html.twig', []);
    }
}
