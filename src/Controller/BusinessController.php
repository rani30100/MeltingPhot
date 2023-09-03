<?php

namespace App\Controller;
use Google\Service\Analytics;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BusinessController extends AbstractController
{
    public function initializeAnalytics(KernelInterface $kernel)
    {
        $KEY_FILE_LOCATION = $kernel->getProjectDir() . '/googleCredentials.json';

        $client = new \Google_Client();
        $client->setRedirectUri('http://127.0.0.1:8000/oauth2callback.php');
        $client->setAccessType('offline');
        $client->setApplicationName('Analytics Reporting');
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(Analytics::ANALYTICS_READONLY);

        if (!isset($_SESSION['access_token'])) {
            // Si le jeton d'accès n'est pas dans la session, redirigez l'utilisateur vers la page d'autorisation
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit;
        }

        $accessToken = $_SESSION['access_token'];

        // Vérifiez si le jeton d'accès est expiré
        if ($client->isAccessTokenExpired()) {
            // Si le jeton d'accès est expiré, utilisez le jeton de rafraîchissement pour en obtenir un nouveau
            $newAccessToken = $client->fetchAccessTokenWithRefreshToken($accessToken['refresh_token']);
            // Mettez à jour le jeton d'accès dans la session
            $_SESSION['access_token'] = $newAccessToken;
            $accessToken = $newAccessToken;
        }

        // Assurez-vous que le jeton d'accès est configuré dans le client
        $client->setAccessToken($accessToken);

        $analytics = new Analytics($client);
        return $analytics;
    }



    
    
    #[Route('/business', name: 'app_business')]
    public function index(KernelInterface $kernel): Response
    {
        
        $analytics = $this->initializeAnalytics($kernel);

        // // Obtenez la liste des comptes disponibles
        $stats = $this->getAnalyticsData($analytics);

        return $this->render('business/index.html.twig', [
            'stats' => $stats,
        ]);
    }
    private function getAnalyticsData($analytics)
    {
        // Vous pouvez ajouter ici le code pour récupérer les données de Google Analytics
        // Par exemple :
        $viewId = 'ga:YOUR_VIEW_ID';
        $startDate = '7daysAgo';
        $endDate = 'today';
        $metrics = 'ga:sessions,ga:pageviews';
        $results = $analytics->data_ga->get($viewId, $startDate, $endDate, $metrics);
        
        // Dans cet exemple, $results contiendrait les données que vous souhaitez afficher.

        // Retournez les données que vous souhaitez afficher dans la vue Twig
        return [
            'sessions' => $results->getTotalsForAllResults()['ga:sessions'],
            'pageviews' => $results->getTotalsForAllResults()['ga:pageviews'],
        ];
    }
}
