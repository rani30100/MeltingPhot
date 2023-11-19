<?php

namespace App\Controller;

use Google\Client;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Category;
use Google\Service\YouTube;
use App\Repository\EbookRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionsController extends AbstractController
{
    //Recuperaton des videos ytb
    private function fetchYouTubeVideos(): ?array
    {
        $client = $this->createGoogleApiClient();
        $youtube = new YouTube($client);

        // Récupère la liste des videos de la playlist "Je film mon futur métier"
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


    #[Route('/video/{id}', name: 'app_video_detail')]
    public function redirectToVideo(int $id = null, VideoRepository $videoRepository): Response
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



    #[Route('/actions/{category}', defaults: ['category' => 'Je_Filme_Mon_Futur_Métier'], methods: ['GET', 'HEAD'], name: 'app_actions', requirements: ['category' => 'Je_Filme_Mon_Futur_Métier|Odonymes|Les_Critiques_pétillantes|Parole_Public|Les_Vitrines_des_Cévènnes'])]
    public function index(string $category = null, EntityManagerInterface $entityManager, EbookRepository $ebooks, CacheInterface $cache, VideoRepository $videoRepository): Response
    {
        $cache = new FilesystemAdapter();
        // Essayez de récupérer les vidéos depuis le cache s'ils sont disponibles
        $cachedVideos = $cache->getItem('playlist_videos');
    
        // Récupérez les vidéos depuis la base de données en fonction de la catégorie sélectionnée
        $videos = $videoRepository->findByCategoryName($category);
    
        if (empty($videos)) {
            // Si les vidéos ne sont pas en base de données, récupérez-les depuis YouTube
            $youtubeVideos = $this->fetchYouTubeVideos();
    
            if ($youtubeVideos) {
                $videos = [];
    
                foreach ($youtubeVideos as $youtubeVideo) {
                    $videoUrl = 'https://www.youtube.com/embed/' . $youtubeVideo->getSnippet()->getResourceId()->getVideoId();
    
                    // Vérifiez si la vidéo avec la même URL existe déjà dans la base de données
                    $existingVideo = $videoRepository->findOneBy(['url' => $videoUrl]);
    
                    if (!$existingVideo) {
                        // La vidéo n'existe pas dans la base de données, créez-la
                        $video = new Video();
                        $video->setTitle($youtubeVideo->getSnippet()->getTitle());
                        $video->setUrl($videoUrl);
                        $video->setCreatedAt(new DateTimeImmutable($youtubeVideo->getSnippet()->getPublishedAt()));
                        $categoryEntity = $entityManager->getRepository(Category::class)->findOneBy(['name' => $category]);
                        $video->setCategory($categoryEntity);
                        $video->setImage(null);
    
                        $entityManager->persist($video);
    
                        // Ajoutez la vidéo à la liste des vidéos
                        $videos[] = $video;
                    }
                }
    
                $entityManager->flush();
            }
    
            // Mettez en cache les vidéos
            $cachedVideos->set($videos);
            $cachedVideos->expiresAfter(120);
            $cache->save($cachedVideos);
        }
    
        // Vérifiez si les vidéos récupérées sont vides et que la catégorie n'est pas celle par défaut
        if ($category !== 'Je_Filme_Mon_Futur_Métier' && empty($videos)) {
            return $this->render('actions/no_videos.html.twig', [
                'category' => $category
            ]);
        }
    
        return $this->render('actions/index.html.twig', [
            'videos' => $videos,
            'ebooks' => $ebooks,
            'category' => $category
        ]);
    }
    
}
