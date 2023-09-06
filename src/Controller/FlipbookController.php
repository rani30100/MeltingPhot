<?php

namespace App\Controller;

use App\Entity\Ebook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FlipbookController extends AbstractController
{
    #[Route('/flipbook', name: 'app_flipbook', methods: ['GET', 'HEAD']) ]
    public function index(string $id, EntityManagerInterface $entityManager): Response
    {
        // Convertir la chaîne ID en entier
        $ebookId = (int) $id;
        dd($ebookId);
        // Utiliser l'ID converti pour récupérer l'ebook
        $ebook = $entityManager->getRepository(Ebook::class)->find($ebookId);
        
        // Gérer le cas où l'ebook n'a pas été trouvé
        if (!$ebook) {
            throw $this->createNotFoundException('Flipbook non trouvé.');
        }
        
        return $this->render('Flipbook-hébémag/index.html.twig', [
            'controller_name' => 'FlipbookController',
            'ebook' => $ebook,
        ]);
    }
}
