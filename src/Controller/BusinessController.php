<?php

namespace App\Controller;

use Google\Service\Analytics;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BusinessController extends AbstractController
{
    #[Route('/business', name: 'app_business')]
    public function index(KernelInterface $kernel): Response
    {
        $analytics = $this->initializeAnalytics($kernel);

        // Vérifiez si l'utilisateur est déjà connecté
        if (!$this->isUserConnected($analytics)) {
            // Redirigez l'utilisateur vers l'authentification Google
            $authUrl = $analytics->createAuthUrl();
            return $this->redirect($authUrl);
        }

        // Obtenez les statistiques Google Analytics
        $stats = $this->getAnalyticsData($analytics);

        return $this->render('business/index.html.twig', [
            'stats' => $stats,
        ]);
    }

    private function initializeAnalytics(KernelInterface $kernel): \Google_Client
    {
        $KEY_FILE_LOCATION = $kernel->getProjectDir() . '/googleCredentials.json';

        $client = new \Google_Client();
        $client->setRedirectUri('http://127.0.0.1:8000/oauth2callback.php');
        $client->setAccessType('offline');
        $client->setApplicationName('Analytics Reporting');
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(Analytics::ANALYTICS_READONLY);

        return $client;
    }

    private function isUserConnected($analytics): bool
    {
        // Vérifiez si le jeton d'accès existe et s'il est encore valide
        if ($analytics->getAccessToken()) {
            return !$analytics->isAccessTokenExpired();
        }

        return false;
    }

    private function getAnalyticsData($analytics): array
    {
        $viewId = 'ga:YOUR_VIEW_ID'; // Remplacez par l'ID de vue réel
        $startDate = '7daysAgo';
        $endDate = 'today';
        $metrics = 'ga:sessions,ga:pageviews';
        
        try {
            $results = $analytics->data_ga->get($viewId, $startDate, $endDate, $metrics);
            
            return [
                'sessions' => $results->getTotalsForAllResults()['ga:sessions'],
                'pageviews' => $results->getTotalsForAllResults()['ga:pageviews'],
            ];
        } catch (\Exception $e) {
            // Gérer les erreurs, par exemple, en enregistrant les erreurs ou en affichant un message d'erreur à l'utilisateur.
            return [
                'sessions' => 0,
                'pageviews' => 0,
            ];
        }
    }
}
