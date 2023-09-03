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
    public function __construct(
        #[Autowire('%env(GOOGLE_API_KEY)%')]
        private $apiKey,
    ) {
    }

    #[Route('/business', name: 'app_business')]
    public function index(KernelInterface $kernel): Response
    {
        $KEY_FILE_LOCATION = $kernel->getProjectDir() . '/googleCredentials.json';

        $client = new \Google_Client();
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->addScope(\Google_Service_Analytics::ANALYTICS_READONLY); // Utilisez le scope approprié pour la lecture seule

        // Définissez le token d'accès si nécessaire
        // $client->setAccessToken($accessToken);

        // Si vous n'avez pas déjà un jeton d'accès, vous devrez obtenir l'autorisation de l'utilisateur
        if (!$client->getAccessToken()) {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit;
        }

        $analytics = new Analytics($client);

        // Obtenez la liste des comptes disponibles
        $accounts = $analytics->management_accounts->listManagementAccounts();

        // Obtenez les données de la première vue (property) disponible
        if (!empty($accounts->getItems())) {
            $account = $accounts->getItems()[0];
            $properties = $analytics->management_webproperties->listManagementWebproperties($account['id']);
            if (!empty($properties->getItems())) {
                $property = $properties->getItems()[0];
                $views = $analytics->management_profiles->listManagementProfiles($account['id'], $property['id']);
                if (!empty($views->getItems())) {
                    $view = $views->getItems()[0];

                    // Obtenez des données spécifiques pour cette vue
                    $viewId = 'ga:' . $view['id'];
                    $startDate = '7daysAgo'; // Période de début souhaitée (ex. : '7daysAgo' pour les 7 derniers jours)
                    $endDate = 'today'; // Période de fin souhaitée (ex. : 'today' pour aujourd'hui)
                    $metrics = 'ga:sessions,ga:pageviews'; // Les métriques que vous souhaitez récupérer

                    $results = $analytics->data_ga->get($viewId, $startDate, $endDate, $metrics);

                    // Vous pouvez maintenant utiliser $results pour obtenir les données de statistiques
                    dd($results);
                }
            }
        }

        return $this->render('business/index.html.twig', [
            // 'stats' => $stats,
        ]);
    }
}
