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
        $linkToVideos = [];
        foreach ($videoResults as $videoResult) {
            $category = str_replace('/', '_', $videoResult->getCategory());
            $videoId = $videoResult->getId();
            // Get the locale from the request (if needed)
            // $locale = $request->getLocale();
            $linkToVideos[] = $this->generateUrl('app_video_detail', [
                'category' => $category, // Use 'category' here instead of $video->getCategory()
                'id' => $videoId,        // Use 'id' here instead of $video->getId()
            ]);
        }

        // Concatenate the results in a single array
        $results = array_merge($ebooks, $videoResults, $images, $posts);

        // Paginer les résultats
        $pagination = $paginator->paginate(
            $results, // Requete donnée pour paginer
            $request->query->getInt('page', 1), // Page par défault
            30 // Nombre items par page
        );

        return $this->render('search/search_results.html.twig', [
            'query' => $query,
            'pagination' => $pagination,
            'videoPageUrls' => $linkToVideos,
        ]);
    }
}
