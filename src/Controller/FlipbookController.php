<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlipbookController extends AbstractController
{
    #[Route('/flipbook', name: 'app_flipbook')]
    public function index(): Response
    {
        return $this->render('flipbook/index.html.twig', [
            'controller_name' => 'FlipbookController',
        ]);
    }
}
