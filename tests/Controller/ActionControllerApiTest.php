<?php

namespace App\Tests\Controller;

use App\Entity\Video;
use App\Entity\Category;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActionsControllerTest extends WebTestCase
{
    public function testActionsCategoryApi(): void
    {
        // Obtenez le client de test
        $client = static::createClient();
        
        // Obtenez l'EntityManager de Doctrine à partir du conteneur de services
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        $categoryId = new Category();
        $categoryId->setName("NewCategory");
        // Persistez l'entité Video dans la base de données de test
        $entityManager->persist($categoryId);
        $entityManager->flush();


        // Créez une instance de la classe Video
        $video = new Video();
        $video->setCreatedAt(new \DateTimeImmutable());
        $video->setName('fictifName');
        $video->setUrl("https://www.youtube.com/watch?v=MEasKckqHDc&t=51s");
        $video->setCategory($categoryId);


        // Persistez l'entité Video dans la base de données de test
        $entityManager->persist($video);
        $entityManager->flush();


        // Envoyer une requête GET à l'endpoint /actions/{category} avec la catégorie 'Je_Filme_Mon_Futur_Métier'
        $client->request('GET', '/actions');

        // Vérifier que la requête s'est bien déroulée (code de réponse 200)
        $this->assertResponseIsSuccessful();

        // Vérifier que les vidéos sont bien affichées dans le carrousel
        $this->assertSelectorExists('.carousel-item'); // Vérifier la présence d'éléments avec la classe 'carousel-item' (représentant les vidéos dans le carrousel)
        $this->assertGreaterThan(0, $client->getCrawler()->filter('.carousel-item')->count()); // Vérifier qu'il y a au moins une vidéo dans le carrousel
    }
}
