<?php

namespace App\Controller;

use App\Repository\EbookRepository;
use App\Repository\ImageRepository;
use App\Repository\PostsRepository;
use App\Repository\VideoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search_results')]
    public function searchResults(Request $request, EbookRepository $ebookRepository, VideoRepository $videoRepository, ImageRepository $imageRepository, PostsRepository $postRepository, PaginatorInterface $paginator): Response
    {
        $query = $request->get('q');

        $ebooks = $ebookRepository->findByQuery($query);
        $images = $imageRepository->findByQuery($query);
        $posts = $postRepository->findByQuery($query);

        // Fetch video results with video page URLs
        $videoResults = $videoRepository->findByQuery($query);

        // Generate the video page URLs for each video result
        $videoPageUrls = [];
        foreach ($videoResults as $videoResult) {
            $category = str_replace('/', '_', $videoResult->getCategory());
            $url = $videoResult->getId();
            // Obtenez la locale actuelle
            $locale = $request->getLocale();
            $videoPageUrls[] = 'http://127.0.0.1:8000' . $locale . 'actions/' . $category . '/' . $url;        }

        // Concatenate the results in a single array
        $results = array_merge($ebooks, $videoResults, $images, $posts);

        // Paginer les résultats
        $pagination = $paginator->paginate(
            $results, // Requete donnée pour paginer
            $request->query->getInt('page', 1), // Page par défault
            10 // Nombre items par page
        );

        return $this->render('search/search_results.html.twig', [
            'query' => $query,
            'pagination' => $pagination,
            'videoPageUrls' => $videoPageUrls,
        ]);
    }
}
