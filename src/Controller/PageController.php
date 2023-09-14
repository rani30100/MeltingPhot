<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Page; // Import the Page entity class
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/{slug}", name: "app_page_show", priority: -1, requirements: ["slug" => ".*"])]    
    public function show(Page $page, EntityManagerInterface $entityManager,ImageRepository $images): Response
    {
        

        // Check if a page with the given slug exists
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }
        $imageRepository = $this->entityManager->getRepository(Image::class);

        $images = $imageRepository->findBy(['page' => $page]);
        
        // If the page exists, render it
        return $this->render('page/index.html.twig', [
            'page' => $page,
            'images' => $images,
        ]);
    }
}
