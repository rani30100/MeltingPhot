<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrangeController extends AbstractController
{
    #[Route('/orange', name: 'app_orange')]
    public function index(): Response
    {
      

        $jsFiles = [
            
            'http://127.0.0.1:8000/js/flipbook/magazine.js',
        ];
        $cssFiles = [
            'assets/styles/flipbook/magazine.css',
           
        ];
       
       

        return $this->render('orange/index.html.twig', [
            'controller_name' => 'OrangeController',
            'jsFiles' => $jsFiles,
            'cssFiles' => $cssFiles,
        ]);
    }
}
