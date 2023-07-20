<?php
namespace App\Controller;

use Google\Client;
use Google\Service\Analytics;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Dotenv\Dotenv;


class BusinessController extends AbstractController
{
    #[Route('/business', name: 'app_business')]
    public function index(): Response
    {
        $KEY_FILE_LOCATION = '/var/www/html/Projet-MeltingPhot/vendor/google/google_credentials.json';


        // Instantiate the Google\Client
        $client = new Client();
        // Set the path to the JSON file containing the credentials
        $client->setAuthConfig($KEY_FILE_LOCATION);
        
        // Authorize the client
        $client->setScopes([
            'https://www.googleapis.com/auth/analytics.readonly',
        ]);
        
        // Create a new Google_Service_Analytics object
        $analyticsService = new \Google_Service_Analytics($client);
        
        // Make a request to retrieve the analytics data
        $analyticsData = $analyticsService->data_ga->get(
            'G-XLMQDM4797', // Replace with your Google Analytics View ID
            '2023-07-01',   // Start date
            '2023-07-31',   // End date
            'ga:users,ga:sessions,ga:pageviews' // Metrics to retrieve
        );
        
        // Extract the statistics from the response
        $stats = [
            'users' => $analyticsData['totalsForAllResults']['ga:users'],
            'sessions' => $analyticsData['totalsForAllResults']['ga:sessions'],
            'pageviews' => $analyticsData['totalsForAllResults']['ga:pageviews'],
        ];
         
        return $this->render('business/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}
