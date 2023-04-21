<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Google\Client;

class ActionsController extends AbstractController
{
    #[Route('/actions/{order}/{year}', defaults: ['order' => 'test','year'=>'null'], methods: ['GET', 'HEAD'], name: 'app_actions')]
    public function index(string $order,string $year, EntityManagerInterface $entityManager, Request $request): Response
    {
        // dd($order);

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
        // dd($playlistItemsResponse);
        // Récupérez toutes les pages de résultats si la playlist contient plus de 50 vidéos
        while ($playlistItemsResponse) {
            foreach ($playlistItemsResponse['items'] as $playlistItem) {
                $videos[] = $playlistItem;
            }
            // Vérifiez si une autre page de résultats existe, et récupérez-la si c'est le cas
            $nextPageToken = $playlistItemsResponse['nextPageToken'];
            if ($nextPageToken) {
                $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
                    'playlistId' => 'YOUR_PLAYLIST_ID',
                    'maxResults' => 50,
                    'pageToken' => $nextPageToken
                ));
            } else {
                $playlistItemsResponse = null;
            }
        }


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

   
        return $this->render('actions/index.html.twig', [
            'controller_name' => 'ActionsController',
            'videos' => $videos,
        ]);
    }
}
