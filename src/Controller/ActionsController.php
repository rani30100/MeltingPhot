<?php
namespace App\Controller;

use Google\Client;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Category;
use Google\Service\YouTube;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionsController extends AbstractController
{
    #[Route('/actions/{category}', defaults: ['category' => 'Je_Filme_Mon_Futur_Métier'], methods: ['GET', 'HEAD'], name: 'app_actions')]
    public function index(string $category = null, EntityManagerInterface $entityManager, CacheInterface $cache): Response
    {
         // Fetch videos from the cache if available
         $videos = $cache->get('playlist_videos', function (ItemInterface $item) use ($category, $entityManager) {
            // Fetch videos from the database for the specified category
            $videoRepository = $entityManager->getRepository(Video::class);
            $videos = $videoRepository->findByCategory($category);

            // If there are no videos for the category in the database, fetch and store them from YouTube
            if (empty($videos)) {
                $youtubeVideos = $this->fetchYouTubeVideos();

                if ($youtubeVideos) {
                    $imageIndex = 0;
                    foreach ($youtubeVideos as $youtubeVideo) {
                        $videoUrl = 'https://www.youtube.com/embed/' . $youtubeVideo->getSnippet()->getResourceId()->getVideoId();

                        // Check if the video with the same URL already exists in the database
                        $existingVideo = $videoRepository->findOneBy(['url' => $videoUrl]);

                        if (!$existingVideo) {
                            // Video does not exist in the database, create and persist it
                            $video = new Video();
                            $video->setTitle($youtubeVideo->getSnippet()->getTitle());
                            $video->setUrl($videoUrl);
                            $video->setCreatedAt(new DateTimeImmutable($youtubeVideo->getSnippet()->getPublishedAt()));

                            $category = $entityManager->getRepository(Category::class)->find(2);
                            $video->setCategory($category);

                            // Get the thumbnail URL using the video ID
                            $thumbnailUrl = $this->getImage($youtubeVideo->getSnippet()->getResourceId()->getVideoId());
                            $video->setImage($thumbnailUrl);

                            // Assign the image path based on the image index
                            $imagePath = '/img/videos/' . $imageIndex . '.jpg';
                            $video->setImage($imagePath);

                            $entityManager->persist($video);

                            // Increment the image index for the next video
                            $imageIndex++;
                        }
                    }

                    $entityManager->flush();
                    $videos = $videoRepository->findByCategory($category);
                }
            }

            // Store the fetched videos in the cache for future use
            $item->expiresAfter(3600); // Cache for 1 hour
            $item->set($videos);

            return $videos;
        });

        // If the fetched videos are empty and the category is not the default one, render the "novideo.html.twig" template
        if ( $category !== 'Je_Filme_Mon_Futur_Métier') {
            return $this->render('actions/no_videos.html.twig', [
                'category' => $category,
            ]);
    }
        return $this->render('actions/index.html.twig', [
            'videos' => $videos,
        ]);
    }

    //Recuperaton des videos ytb
    private function fetchYouTubeVideos(): ?array
    {
        $client = $this->createGoogleApiClient();
        $youtube = new YouTube($client);

        // Retrieve the list of videos from the playlist "Je film mon futur métier"
        $playlistMonFuturMetier = $youtube->playlistItems->listPlaylistItems('snippet', [
            'playlistId' => 'PLU8CGazlBJAsyM9QsrvGUK3SIDpUHngJl',
            'maxResults' => 50,
            'part' => 'snippet,status',
        ]);

        $filteredPlaylistItems = [];
        foreach ($playlistMonFuturMetier->getItems() as $item) {
            $status = $item->getStatus()->getPrivacyStatus();
            if ($status === 'public' || $status === 'private') {
                $filteredPlaylistItems[] = $item;
            }
        }

        return $filteredPlaylistItems;
    }

    //Connection a l'api Ytb
    private function createGoogleApiClient(): Client
    {
        $client = new Client();
        $client->setApplicationName('MeltingPhot');
        $client->setDeveloperKey('AIzaSyDNbPQ6M-fqyLQCyRNtkdJuhIdLDS1CoP4');
        return $client;
    }

    private function getImage(string $videoId): ?string
    {
        $client = $this->createGoogleApiClient();
        $youtube = new YouTube($client);

        // Retrieve video details, including the thumbnail URL
        $videoDetails = $youtube->videos->listVideos('snippet', [
            'id' => $videoId,
            'part' => 'snippet',
        ]);

        if ($videoDetails->getItems()) {
            return $videoDetails->getItems()[0]->getSnippet()->getThumbnails()->getDefault()->getUrl();
        }

        return null;
    }
}
