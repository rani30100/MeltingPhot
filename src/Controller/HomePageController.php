<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatableMessage;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(TranslatorInterface $translator): Response
    {    

        return $this->render('home_page/index.html.twig', [
      
        ]);
    }
}
