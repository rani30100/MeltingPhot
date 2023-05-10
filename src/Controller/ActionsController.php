<?php

namespace App\Controller;

use Google\Client;
use Google\Service\YouTube;
use App\Entity\Video;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionsController extends AbstractController
{
    #[Route('/actions/{order}/{year}', defaults: ['order' => 'test', 'year' => 'null'], methods: ['GET', 'HEAD'], name: 'app_actions')]
    public function index(string $order, string $year,EntityManagerInterface $entityManager, Request $request): Response
    {
        
        $cache = new FilesystemAdapter();
        $videos = $cache->get("videos_" . $order . "_" . $year, function (ItemInterface $item) use ($order) {
            // Créez un client API Google
            $client = new Client();
            $client->setApplicationName('MeltingPhot');
            $client->setDeveloperKey('AIzaSyDSrLD28H3nq5c6Mu4vD2UjAkD4clurAw4');

            // Créez un objet pour l'API YouTube Data
            $youtube = new \Google\Service\YouTube($client);

            // Récupérez la liste des vidéos de la playlist
            $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
                'playlistId' => 'PLU8CGazlBJAsyM9QsrvGUK3SIDpUHngJl',
                'maxResults' => 50,
                'part' => 'snippet'
            ));
            $videos = $playlistItemsResponse->getItems();
            
            // filtrer les vidéos en fonction de l'année de publication
            if ($order == '2023') {
                $videos = array_filter($videos, function ($video) use ($order) {
                    $publishedAt = $video->getSnippet()->getPublishedAt();
                    return substr($publishedAt, 0, 4) == $order;
                });
            }
            // filtrer les vidéos en fonction de l'année de publication
            if ($order == '2022') {
                $videos = array_filter($videos, function ($video) use ($order) {
                    $publishedAt = $video->getSnippet()->getPublishedAt();
                    return substr($publishedAt, 0, 4) == $order;
                });
            }

            if ($order == 'Cheffe') {
                // Trier les vidéos par date de publication (de la plus récente à la plus ancienne)
                usort($videos, function ($a, $b) {

                    return strcmp($b['snippet']['publishedAt'], $a['snippet']['publishedAt']);
                });
            }

            if ($order == 'desc') {
                // Trier les vidéos par date de publication (de la plus récente à la plus ancienne)
                usort($videos, function ($a, $b) {
                    return strcmp(strtotime($b['snippet']['publishedAt']), strtotime($a['snippet']['publishedAt']));
                });
            } elseif ($order == 'asc') {
                // Trier les vidéos par date de publication (de la plus récente à la plus ancienne)
                usort($videos, function ($a, $b) {
                    return strcmp(strtotime($a['snippet']['publishedAt']), strtotime($b['snippet']['publishedAt']));
                });
            }
            
            // Récupérer la catégorie "Je filme mon futur métier"
            $category = $entityManager->getRepository(Category::class)->findOneBy(['name' => 'Je filme mon futur métier']);
            $entityManager->persist($category);

           // Parcourir chaque vidéo pour les stocker dans la catégorie "Je filme mon futur métier"
           foreach ($videos as $videoData) {
               // Récupérer le titre de la vidéo
               $title = $videoData->getSnippet()->getTitle();

               // Créer une nouvelle entité Video
               $video = new Video();
               $video->setTitle($title);
               $video->setCategory($category);

               // Enregistrer la vidéo dans la base de données
               $entityManager->persist($video);

           }

           // Exécuter l'opération de persistance
           $entityManager->flush();
           
            return $videos;
        });
        
          



        return $this->render('actions/index.html.twig', [
            'controller_name' => 'ActionsController',
            'videos' => $videos,
        ]);
    }
}