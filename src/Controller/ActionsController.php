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
        // Définissez un tableau associatif pour mapper les catégories à leurs identifiants
        $categoryMappings = [
            'Je_Filme_Mon_Futur_Métier' => 2,
            'Odonymes' => 3,
            'Les_Critiques_pétillantes' => 4,
            'Parole_Public' => 5,
            'Les_Vitrines_des_Cévènnes' => 6,
        ];

        // Vérifiez si la catégorie categorie dans l'URL existe dans le tableau des mappings
        //si elle existe associe $categorie a cet id
        if (array_key_exists($category, $categoryMappings)) {
            $categoryId = $categoryMappings[$category];
        } else {
            // Gére le cas où la catégorie n'est pas reconnue .
            return $this->render('actions/no_videos.html.twig');
        }

        // Récupération de la catégorie à partir de son ID
        $selectedCategory = $entityManager->getRepository(Category::class)->find($categoryId);

        $videos = $videoRepository->findByCategory($selectedCategory);

    
        // Récupération des vidéos depuis la base de données pour la catégorie spécifiée
        $videos = $videoRepository->findByCategory($selectedCategory);
        $JeFilmeMonFuturMetier = $entityManager->getRepository(Category::class)->find(2);



        // Si aucune vidéo n'existe dans la base de données, récupérez-les depuis YouTube et stockez-les
        if (empty($videos)) {
            $youtubeVideos = $this->fetchYouTubeVideos();

            if ($youtubeVideos) {
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
                        $video->setImage('public/uploads/videos/images');
                        $video->setCategory($JeFilmeMonFuturMetier);

                        $entityManager->persist($video);
                    }
                }
                $entityManager->flush();
            }
        }
    
       
        
        // Si aucune vidéo n'a été trouvée, vous pouvez afficher une vue "no_videos.html.twig"
        if (empty($videos)) {
            return $this->render('actions/no_videos.html.twig');
        }

        return $this->render('actions/index.html.twig', [
            'videos' => $videos,
        ]);
    }
}