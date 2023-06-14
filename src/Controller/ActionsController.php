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
    public function index(?string $order ,?string $year, EntityManagerInterface $entityManager, Request $request,Category $category = null): Response
    {
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
                'part' => 'snippet,status',
            ));

            $filteredPlaylistItems = [];

            foreach ($playlistMonfuturmétier->getItems() as $item) {
                $status = $item->getStatus()->getPrivacyStatus();
                if ($status === 'public' || $status === 'private') {
                    $filteredPlaylistItems[] = $item;
                }
            }
            $videos1 = $playlistMonfuturmétier->getItems();
         

            $videoEntities = [];
           
                foreach ($videos1 as $videoData) {
                    $video = new Video();
                    $video->setName($videoData['snippet']['title']);
                    $video->setUrl('https://www.youtube.com/embed/' . $videoData['snippet']['resourceId']['videoId']);
                    $video->setCreatedAt(new DateTimeImmutable($videoData['snippet']['publishedAt']));     
                
                    //Pour determiner la 1ere video 
                    $index = key($videos1);
                    // Récupérer l'URL ou le chemin d'accès de l'image associée à la vidéo
                    $imagePath = '' . $index . '.jpg'; // Remplacez par l'URL ou le chemin d'accès approprié

                    // Assigner le chemin d'accès de l'image à la propriété Image de l'objet Video
                    $video->setImage($imagePath);
                    
                    next($videos1);
                    // Je définis la catégorie pour les videos 
                    $category = $entityManager->getRepository(Category::class)->find(2);
                    $video->setCategory($category);

                    $entityManager->persist($video);
                    $videoEntities[] = $video;
                
                }
                $entityManager->flush(); 
        
            
            return $this->render('actions/index.html.twig', [
                'controller_name' => 'ActionsController',
                'videos' => $videoEntities
            ]);
            
    }

}