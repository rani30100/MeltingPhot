<?php
namespace App\Controller;

use Google\Client;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Category;
use Google\Service\YouTube;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionsController extends AbstractController
{
    public function __construct(
        #[Autowire('%env(GOOGLE_API_YOUTUBE)%')]
        private $apiYoutube,
 
    ) {
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
        $client->setDeveloperKey($this->apiYoutube);
        return $client;
    }




    #[Route('/actions/{category}', defaults: ['category' => 'Je_Filme_Mon_Futur_Métier'], methods: ['GET', 'HEAD'], name: 'app_actions')]
    public function index(string $category = null, EntityManagerInterface $entityManager, CacheInterface $cache, VideoRepository $videoRepository): Response
    { 
   
        $video = new Video();
        
        $videos = $videoRepository->findAll();

        $jeFilmeMonFuturMétier = 'Je_Filme_Mon_Futur_Métier';
        $odonymes = $category === 'Odonymes';
        $lesCritiquesPétillantes = 'Les_Critiques_pétillantes';
        $parolePublic = 'Parole_Public';
        $lesVitrinesDesCévènnes= "Les_Vitrines_des_Cévènnes";

        // Essaye de récupérer les vidéos depuis le cache s'ils sont disponibles
        $cachedVideos = $cache->get('playlist_videos', function (ItemInterface $item) use ($category, $entityManager) {
            
            // Récupération des vidéos depuis la base de données pour la catégorie spécifiée
            $videoRepository = $entityManager->getRepository(Video::class);
            $videos = $videoRepository->findByCategory($category);

            // Si aucune vidéo n'existe pour la catégorie dans la base de données, récupérez-les depuis YouTube et stockez-les
            if (empty($videos)) {
                $youtubeVideos = $this->fetchYouTubeVideos();

                if ($youtubeVideos) {
                    // $imageIndex = 0;
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
                            $video->setImage('public/uploads/videos/images');
        
                            $entityManager->persist($video);
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
        // dd($category === $lesCritiquesPétillantes && empty($video->getUrl()));
        
        if ($category === $odonymes && empty($video->getUrl())) {
            // La catégorie est 'Odonymes' et il n'y a pas de vidéos, donc on affiche le modèle 'novideo.html.twig'
            return $this->render('actions/no_videos.html.twig', [
                'category' => $category
            ]);
        // }else{
            // $videos = $videoRepository->findByCategory($category);

            // return $this->render('actions/index.html.twig', [
            //     'videos' => $video->getUrl(),
            // ]);
        }
        if ($category === $lesCritiquesPétillantes && empty($video->getUrl())) {
            // La catégorie est 'Odonymes' et il n'y a pas de vidéos, donc on affiche le modèle 'novideo.html.twig'
            return $this->render('actions/no_videos.html.twig', [
                'category' => $category
            ]);
        }
        if ($category === $parolePublic && empty($video->getUrl())) {
            // La catégorie est 'Odonymes' et il n'y a pas de vidéos, donc on affiche le modèle 'novideo.html.twig'
            return $this->render('actions/no_videos.html.twig', [
                'category' => $category
            ]);
        }
        if ($category === $lesVitrinesDesCévènnes && empty($video->getUrl())) {
            // La catégorie est 'Odonymes' et il n'y a pas de vidéos, donc on affiche le modèle 'novideo.html.twig'
            return $this->render('actions/no_videos.html.twig', [
                'category' => $category
            ]);
        }
        
        // S'il il n'y a pas de videos misent en cache, prend les videos de la BDD
        $videosToShow = $cachedVideos ?: $videos;   

        return $this->render('actions/index.html.twig', [
            'videos' => $videosToShow,
        ]);
    }
}