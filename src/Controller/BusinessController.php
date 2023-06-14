<?php

namespace App\Controller;

use Google\Client as GoogleClient;
use Google\Service\AnalyticsReporting;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BusinessController extends AbstractController
{
    #[Route('/business', name: 'app_business')]
    public function index(): Response
    {
             // Configure Google API client
             $client = new GoogleClient();
             $client->setAuthConfig('Google/meltingphot-Business.json');
             // Remplacez par le chemin vers votre fichier JSON de configuration client
             $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
     
             // Authentification et création du service Analytics Reporting
             $client->fetchAccessTokenWithAssertion();
             $accessToken = $client->getAccessToken();
             $analytics = new \Google_Service_AnalyticsReporting($client);
     
             // ID de la vue (profil) Google Analytics
             $viewId = '5419813494';
     
             // Date de début et de fin pour les statistiques
             $startDate = new \DateTime('2023-01-01');
             $endDate = new \DateTime();
     
             // Création de la requête de rapport
             $request = new \Google_Service_AnalyticsReporting_ReportRequest();
             $request->setViewId($viewId);
             $request->setDateRanges([
                 new \Google_Service_AnalyticsReporting_DateRange([
                     'startDate' => $startDate->format('Y-m-d'),
                     'endDate' => $endDate->format('Y-m-d'),
                 ]),
             ]);
             $request->setMetrics([
                 new \Google_Service_AnalyticsReporting_Metric([
                     'expression' => 'ga:users',
                 ]),
                 new \Google_Service_AnalyticsReporting_Metric([
                     'expression' => 'ga:sessions',
                 ]),
                 new \Google_Service_AnalyticsReporting_Metric([
                     'expression' => 'ga:pageviews',
                 ]),
             ]);
     
             // Création de la requête de rapport
             $reportRequest = new \Google_Service_AnalyticsReporting_GetReportsRequest();
             $reportRequest->setReportRequests([$request]);
             $reports = $analytics->reports->batchGet($reportRequest);
     
             // Traitement de la réponse du rapport
             $report = $reports[0];
             $rows = $report->getData()->getRows();
     
             $stats = [];
             if (!empty($rows)) {
                 $usersMetric = $rows[0]->getMetrics()[0];
                 $sessionsMetric = $rows[0]->getMetrics()[1];
                 $pageviewsMetric = $rows[0]->getMetrics()[2];
     
                 $stats = [
                     'users' => $usersMetric->getValues()[0],
                     'sessions' => $sessionsMetric->getValues()[0],
                     'pageviews' => $pageviewsMetric->getValues()[0],
                 ];
             }
     
             // Afficher les statistiques sur votre template
             return $this->render('stats/site_stats.html.twig', [
                 'stats' => $stats,
             ]);
         
        return $this->render('business/index.html.twig', [
            'controller_name' => 'BusinessController',
        ]);
    }
}
