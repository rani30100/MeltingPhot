<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusinessStatsController extends AbstractController
{
    #[Route('/admin/business/stats', name: 'app_admin_business_stats')]
    public function index(): Response
    {
        return $this->render('admin/business_stats/index.html.twig', [
            'controller_name' => 'BusinessStatsController',
        ]);
    }
}
