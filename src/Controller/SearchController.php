<?php

namespace App\Controller;

use App\Repository\EbookRepository;
use App\Repository\ImageRepository;
use App\Repository\PostsRepository;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search_results')]
    public function searchResults(Request $request, EbookRepository $ebookRepository, VideoRepository $videoRepository, ImageRepository $imageRepository, PostsRepository $postRepository): Response
    {
        $query = $request->get('q');
    
        $ebooks = $ebookRepository->findByQuery($query);
        $videos = $videoRepository->findByQuery($query);
        $images = $imageRepository->findByQuery($query);
        $posts = $postRepository->findByQuery($query);
    
        // Concaténez les résultats dans un seul tableau
        $results = array_merge($ebooks, $videos, $images, $posts);
    
        return $this->render('search/search_results.html.twig', [
            'results' => $results,
            'query' => $query,
        ]);
    }

}
