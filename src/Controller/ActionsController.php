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
    #[Route('/actions/{category}', defaults: ['category' => null], methods: ['GET', 'HEAD'], name: 'app_actions')]
    public function index(string $category = null, EntityManagerInterface $entityManager, CacheInterface $cache): Response
    {
        if ($category === 'Je_Filme_Mon_Futur_Métier') {
            $videos = $cache->get('playlist_videos', function (ItemInterface $item) use ($entityManager) {
                // Create a Google API client
                $client = new Client();
                $client->setApplicationName('MeltingPhot');
                $client->setDeveloperKey('AIzaSyDNbPQ6M-fqyLQCyRNtkdJuhIdLDS1CoP4');

                // Create an object for the YouTube Data API
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

                $videos = [];
                $imageIndex = 0; // Initial index for the images
                
                foreach ($playlistMonFuturMetier->getItems() as $item) {
                    $status = $item->getStatus()->getPrivacyStatus();
                    if ($status === 'public' || $status === 'private') {
                        $video = new Video();
                        $video->setName($item->getSnippet()->getTitle());
                        $video->setUrl('https://www.youtube.com/embed/' . $item->getSnippet()->getResourceId()->getVideoId());
                        $video->setCreatedAt(new DateTimeImmutable($item->getSnippet()->getPublishedAt()));
                
                        $category = $entityManager->getRepository(Category::class)->find(2);
                        $video->setCategory($category);
                
                        $entityManager->persist($video);
                        $videos[] = $video;
                
                        // Assign the image path based on the image index
                        $imagePath = '/img/videos/' . $imageIndex . '.jpg';
                        $video->setImage($imagePath);

                
                        $imageIndex++; // Increment the image index for the next video
                    }
                }

                $entityManager->flush();

                return $videos;
            });

            return $this->render('actions/index.html.twig', [
                'videos' => $videos,
            ]);
        }

        return $this->render('actions/no_videos.html.twig');
    }
}
