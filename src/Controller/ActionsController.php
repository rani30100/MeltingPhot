<?php
namespace App\Controller;

use Google\Client;
use App\Entity\Ebook;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Category;
use Google\Service\YouTube;
use App\Repository\EbookRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionsController extends AbstractController
{
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


    #[Route('/actions/{category}/{id}', name: 'app_actions_video')]
    public function redirectToVideo(string $category, int $id, VideoRepository $videoRepository): Response
    {
      // Récupérer la vidéo à partir de l'identifiant (ID)
      $video = $videoRepository->find($id);
 
      $videos = $videoRepository->findAll();
      // Si la vidéo n'est pas trouvée, vous pouvez gérer l'erreur ici ou rediriger l'utilisateur vers une page d'erreur.
      if (!$video) {
          throw $this->createNotFoundException('La vidéo n\'existe pas.');
      }

      // Rendre le template de la vue qui affiche le modal avec la vidéo correspondante
      return $this->render('actions/modal_video.html.twig', [
          'video' => $video,
          'videos' => $videos
      ]);
  }
    


    #[Route('/actions/{category}', defaults: ['category' => 'Je_Filme_Mon_Futur_Métier'], methods: ['GET', 'HEAD'], name: 'app_actions')]
    public function index(string $category = null, EntityManagerInterface $entityManager,EbookRepository $ebooks, CacheInterface $cache, VideoRepository $videoRepository): Response
    {
        $ebooks = $ebooks->findAll(['category' => $category]);
        $videos = $videoRepository->findAll();
        // Essaye de récupérer les vidéos depuis le cache s'ils sont disponibles
        $cachedVideos = $cache->get('playlist_videos', function (ItemInterface $item) use ($category, $entityManager) {
            
            // Récupération des vidéos depuis la base de données pour la catégorie spécifiée
            $videoRepository = $entityManager->getRepository(Video::class);
            $videos = $videoRepository->findByCategory($category);

            // Si aucune vidéo n'existe pour la catégorie dans la base de données, récupérez-les depuis YouTube et stockez-les
            if (empty($videos)) {
                $youtubeVideos = $this->fetchYouTubeVideos();

                if ($youtubeVideos) {
                    $imageIndex = 0;
                    foreach ($youtubeVideos as $youtubeVideo) {
                        $videoUrl = 'https://www.youtube.com/embed/' . $youtubeVideo->getSnippet()->getResourceId()->getVideoId();

                        // Vérifier si la vidéo avec la même URL existe déjà dans la base de données
                        $existingVideo = $videoRepository->findOneBy(['url' => $videoUrl]);

                        if (!$existingVideo) {
                            // La vidéo n'existe pas dans la base de données, créez-la et persistez-la
                            $video = new Video();
                            $video->setTitle($youtubeVideo->getSnippet()->getTitle());
                            $video->setUrl($videoUrl);
                            $video->setCreatedAt(new DateTimeImmutable($youtubeVideo->getSnippet()->getPublishedAt()));

                            $category = $entityManager->getRepository(Category::class)->find(2);
                            $video->setCategory($category);

                            // Obtenez l'URL de la miniature en utilisant l'ID de la vidéo
                            $thumbnailUrl = $this->getImage($youtubeVideo->getSnippet()->getResourceId()->getVideoId());
                            $video->setImage($thumbnailUrl);

                            // Assigner le chemin de l'image en fonction de l'index de l'image
                            $imagePath = '/img/videos/' . $imageIndex . '.jpg';
                            $video->setImage($imagePath);

                            $entityManager->persist($video);

                            // Incrémentez l'index de l'image pour la vidéo suivante
                            $imageIndex++;
                        }
                    }

                    $entityManager->flush();
                    $videos = $videoRepository->findByCategory($category);
                }
            }

            // Stocker les vidéos récupérées dans le cache pour une utilisation future
            $item->expiresAfter(3600); // Cache pendant 1 heure
            $item->set($videos);
            return $videos;
        });

        // Si les vidéos récupérées sont vides et que la catégorie n'est pas celle par défaut, rend le template "novideo.html.twig"
        if ($category !== 'Je_Filme_Mon_Futur_Métier' && empty($cachedVideos)) {
            return $this->render('actions/no_videos.html.twig', [
            'category' => $category
        ]);
        }


        // S'il il n'y a pas de videos misent en cache, prend les videos de la BDD
        $videosToShow = $cachedVideos ?: $videos;

        return $this->render('actions/index.html.twig', [
            'videos' => $videosToShow,
            'ebooks' => $ebooks,
            'category' => $category

        ]);
    }
}