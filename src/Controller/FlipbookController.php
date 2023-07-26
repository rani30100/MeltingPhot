<?php
namespace App\Controller;

use Spatie\PdfToImage\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FlipbookController extends AbstractController
{
    #[Route('/flipbook/Hébémag', name: 'app_flipbook')]
    public function index(): Response
    {
        $hébémag = 'uploads/ebook/hebemag.pdf'; 
        $pathToHébémagImage = 'uploads/hébémag/'; // Chemin de l'image extraite
    
        try {
            // Créez une instance Pdf
            $pdf = new Pdf($hébémag);
    
            // Extrayez toutes les images du PDF et enregistrez-les dans le répertoire de destination
            $images = $pdf->saveAllPagesAsImages($pathToHébémagImage);
    
            // Créez un tableau pour stocker les noms des images extraites (sans le chemin complet)
            $imagePaths = [];

            // Ajoutez les noms des images au tableau
            foreach ($images as $image) {
                $imagePaths[] = basename($image);
            }
        } catch (\Exception $e) {
            // Gérez les erreurs éventuelles lors de l'extraction des images
            echo "Erreur lors de l'extraction des images : " . $e->getMessage();
        }
    
        return $this->render('Flipbook-hébémag/index.html.twig', [
            'controller_name' => 'FlipbookController',
            'imagePaths' => $imagePaths,
        ]);
    }
}
