<?php

namespace App\Controller;

use Google\Client;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Category;
use Google\Service\YouTube;
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
    public function index(string $order, string $year, EntityManagerInterface $entityManager, Request $request,Category $category = null): Response
    {
        $cache = new FilesystemAdapter();
        $videoEntities = $cache->get("videos_" . $order . "_" . $year, function (ItemInterface $item) use ($order, $entityManager) {
            // Créez un client API Google
            $client = new Client();
            $client->setApplicationName('MeltingPhot');
            $client->setDeveloperKey('AIzaSyDSrLD28H3nq5c6Mu4vD2UjAkD4clurAw4');

            // Créez un objet pour l'API YouTube Data
            $youtube = new \Google\Service\YouTube($client);

            // Récupérez la liste des vidéos de la playlist Je film mon futur métier
            $playlistMonfuturmétier = $youtube->playlistItems->listPlaylistItems('snippet', array(
                'playlistId' => 'PLU8CGazlBJAsyM9QsrvGUK3SIDpUHngJl',
                'maxResults' => 50,
                'part' => 'snippet,status'
            ));

               // Récupérez la liste des vidéos de la playlist Odonymes
               $playlistOdonymes = $youtube->playlistItems->listPlaylistItems('snippet', array(
                'playlistId' => 'PLU8CGazlBJAsq1vzyPDWX5tEWT7aDS325',
                'maxResults' => 50,
                'part' => 'snippet'
            ));
            $videos1 = $playlistMonfuturmétier->getItems();
            $videos2 = $playlistOdonymes ->getItems();

            $videoEntities = [];
            try {
                foreach ($videos1 as $videoData) {
                    $video = new Video();
                    $video->setName($videoData['snippet']['title']);
                    $video->setUrl('https://www.youtube.com/watch?v=' . $videoData['snippet']['resourceId']['videoId']);
                    $video->setCreatedAt(new DateTimeImmutable($videoData['snippet']['publishedAt']));
                    // Je définis la catégorie pour les videos 
                    $category = $entityManager->getRepository(Category::class)->find(2);
                    $video->setCategory($category);

                    $entityManager->persist($video);
                    $videoEntities[] = $video;
                
                }
            } catch (\Exception $e) {
                // Afficher les éventuelles erreurs de persistance
                dd($e->getMessage('Ca marche pas mec'));
            }

            $entityManager->flush();

            // filtrer les vidéos en fonction de l'année de publication
            if ($order == '2023') {
                $videoEntities = array_filter($videoEntities, function ($video) use ($order) {
                    $publishedAt = $video->getCreatedAt();
                    return $publishedAt->format('Y') == $order;
                });
            }
            // filtrer les vidéos en fonction de l'année de publication
            if ($order == '2022') {
                $videoEntities = array_filter($videoEntities, function ($video) use ($order) {
                    $publishedAt = $video->getCreatedAt();
                    return                     $publishedAt->format('Y') == $order;
                });
            }

            if ($order == 'Cheffe') {
                // Trier les vidéos par date de publication (de la plus récente à la plus ancienne)
                usort($videoEntities, function ($a, $b) {
                    return $b->getCreatedAt() <=> $a->getCreatedAt();
                });
            }

            if ($order == 'desc') {
                // Trier les vidéos par date de publication (de la plus récente à la plus ancienne)
                usort($videoEntities, function ($a, $b) {
                    return $b->getCreatedAt() <=> $a->getCreatedAt();
                });
            } elseif ($order == 'asc') {
                // Trier les vidéos par date de publication (de la plus ancienne à la plus récente)
                usort($videoEntities, function ($a, $b) {
                    return $a->getCreatedAt() <=> $b->getCreatedAt();
                });
            }

            if ($category) {
                $videoEntities = $entityManager->getRepository(Video::class)->findBy(['category' => $category]);
                return $videoEntities;
            } else {
                $videoEntities = $entityManager->getRepository(Video::class)->findAll();
            }

            return $videoEntities;
        });

        return $this->render('actions/index.html.twig', [
            'controller_name' => 'ActionsController',
            'videos' => $videoEntities,
        ]);
    }
}
