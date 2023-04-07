<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageEnController extends AbstractController
{
    #[Route('/en', name: 'app_home_page_e_n')]
    public function index(): Response
    {
        return $this->render('home_page_en/index.html.twig', [
            'controller_name' => 'HomePageEnController',
        ]);
    }
}
