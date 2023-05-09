<?php

namespace App\Controller;

use Google\Client;
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
        // dd($order);

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

            // Récupérer la catégorie "Je filme mon futur métier"
            $category = $entityManager->getRepository(Category::class)->findOneBy(['name' => 'Je filme mon futur métier']);

            // Parcourir chaque vidéo pour les stocker dans la catégorie "Je filme mon futur métier"
            foreach ($playlistItemsResponse['items'] as $playlistItem) {
                // Récupérer le titre de la vidéo
                $title = $playlistItem['snippet']['title'];

                // Créer une nouvelle entité Video
                $video = new Video();
                $video->setTitle($title);
                $video->setCategory($category);

                // Enregistrer la vidéo dans la base de données
                $entityManager->persist($video);
            }

            // Exécuter l'opération de persistance
            $entityManager->flush();
           



            // filtrer les vidéos en fonction de l'année de publication
            if ($order == '2023') {
                $videos = array_filter($videos, function ($video) {
                    return substr($video['snippet']['publishedAt'], 0, 4) == '2023';
                });
            }
            // filtrer les vidéos en fonction de l'année de publication
            if ($order == '2022') {
                $videos = array_filter($videos, function ($video) {
                    return substr($video['snippet']['publishedAt'], 0, 4) == '2022';
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

            return $videos;
        });


        return $this->render('actions/index.html.twig', [
            'controller_name' => 'ActionsController',
            'videos' => $videos,
        ]);
    }
}
 // // Parcourez chaque vidéo pour les trier par catégorie
            // foreach ($playlistItemsResponse['items'] as $playlistItem) {
            //     // Récupérez le titre de la vidéo
            //     $title = $playlistItem['snippet']['title'];

            //     // Trier les vidéos par catégorie
            //     if (strpos($title, 'Les critiques pétillantes') !== false) {
            //         // Inclure la vidéo dans la catégorie 'Les critiques pétillantes'
            //         $lesCritiquesPetillantesVideos[] = $playlistItem;
            //     } elseif (strpos($title, 'Je filme mon futur métier') !== false) {
            //         // Inclure la vidéo dans la catégorie 'Je filme mon futur métier'
            //         $jeFilmeMonFuturMetierVideos[] = $playlistItem;
            //     } elseif (strpos($title, 'Odonymes') !== false) {
            //         // Inclure la vidéo dans la catégorie 'Odonymes'
            //         $odonymesVideos[] = $playlistItem;
            //     } elseif (strpos($title, 'Parole public') !== false) {
            //         // Inclure la vidéo dans la catégorie 'Parole public'
            //         $parolePublicVideos[] = $playlistItem;
            //     } elseif (strpos($title, 'Les vitrines des cévénnes') !== false) {
            //         // Inclure la vidéo dans la catégorie 'Les vitrines des cévénnes'
            //         $lesVitrinesDesCevennesVideos[] = $playlistItem;
            //     }
            // }
            // // dd($playlistItemsResponse);
            // // Récupérez toutes les pages de résultats si la playlist contient plus de 50 vidéos
            // while ($playlistItemsResponse) {
            //     foreach ($playlistItemsResponse['items'] as $playlistItem) {
            //         $videos[] = $playlistItem;
            //     }
            //     // Vérifiez si une autre page de résultats existe, et récupérez-la si c'est le cas
            //     $nextPageToken = $playlistItemsResponse['nextPageToken'];
            //     if ($nextPageToken) {
            //         $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
            //             'playlistId' => 'YOUR_PLAYLIST_ID',
            //             'maxResults' => 50,
            //             'pageToken' => $nextPageToken
            //         ));
            //     } else {
            //         $playlistItemsResponse = null;
            //     }
            // }
