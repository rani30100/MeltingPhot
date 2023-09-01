<?php

namespace App\Controller;

use App\Entity\Page; // Import the Page entity class
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    #[Route("/{slug}", name: "app_page_show", priority: -1)]
    public function show(Page $page): Response
    {
        // Check if a page with the given slug exists
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }

        // If the page exists, render it
        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
