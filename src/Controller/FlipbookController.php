<?php

namespace App\Controller;

use SplFileObject;
use App\Entity\Ebook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FlipbookController extends AbstractController
{
    #[Route('/flipbook/{id}', name: 'app_flipbook', methods: ['GET', 'HEAD'])]
    public function index(Ebook $ebook, EntityManagerInterface $entityManager): Response
    {
        $ebook = $ebook->getPdf();





        $pdfPath = '/uploads/ebook/pdf/' . $ebook;

        return $this->render('Flipbook/index.html.twig', [
            'pdfPath' => $pdfPath,
        ]);
    }
}





// // Répertoire principal pour stocker les images extraites
// $imageDirectory = $this->getParameter('kernel.project_dir') . '/public/ebook-images/';

// // Créez un sous-dossier unique pour chaque eBook en utilisant son ID
// $ebookImageDirectory = $imageDirectory . 'ebook_' . $ebook->getId() . '/';

// // Vérifiez si le répertoire du livre existe déjà, sinon, créez-le
// if (!is_dir($ebookImageDirectory)) {
//     mkdir($ebookImageDirectory, 0777, true);
// }

// // Vérifiez si le répertoire contient déjà des images ou non
// if (count(glob($ebookImageDirectory . '*')) === 0) {
//     // Le répertoire est vide, extrayez les images
//     $pdfPath = 'uploads/ebook/' . $ebook->getPdf();

//     // Chemin vers le répertoire de sortie pour les images
//     $outputDirectory = $ebookImageDirectory;

//     // Ouvrir le fichier PDF
//     $pdf = new SplFileObject($pdfPath);

//     // Lire le contenu du PDF en tant que chaîne
//     $pdfContent = $pdf->fread($pdf->getSize());

//     // Utiliser une expression régulière pour extraire les images
//     $pattern = '/\/XObject\n<<([\s\S]*?)>>/m';
//     preg_match_all($pattern, $pdfContent, $matches);

//     $images = [];

//     // Bouclez à travers les correspondances (chaque page)
//     foreach ($matches[1] as $pageContent) {
//         // Utilisez une expression régulière pour extraire les images de la page
//         $imagePattern = '/\/Subtype\s*\/Image[\s\S]*?\/Filter[\s\S]*?\[\s*\/DCTDecode\s*]/m';
//         preg_match_all($imagePattern, $pageContent, $imageMatches);

//         // Bouclez à travers les images de la page
//         foreach ($imageMatches[0] as $imageContent) {
//             // Utilisez une expression régulière pour extraire les données de l'image
//             $dataPattern = '/stream(.*?)endstream/ms';
//             preg_match($dataPattern, $imageContent, $dataMatches);

//             // Les données de l'image sont dans $dataMatches[1]
//             $imageData = $dataMatches[1];

//             // Générez un nom de fichier unique pour l'image
//             $imageName = 'image_' . uniqid() . '.jpg';

//             // Écrivez les données de l'image dans un fichier
//             file_put_contents($outputDirectory . $imageName, $imageData);

//             // Ajoutez le nom de fichier à la liste des images
//             $images[] = 'ebook-images/ebook_' . $ebook->getId() . '/' . $imageName;
//         }
//     }
// } else {
//     // Le répertoire contient déjà des images, utilisez-les
//     $imageFiles = scandir($ebookImageDirectory);
//     $imageFiles = array_diff($imageFiles, ['.', '..']);
//     $images = [];

//     foreach ($imageFiles as $fileName) {
//         $images[] = 'ebook-images/ebook_' . $ebook->getId() . '/' . $fileName;
//     }
// }



        // // Répertoire principal pour stocker les images extraites
        // $imageDirectory = $this->getParameter('kernel.project_dir') . '/public/ebook-images/';

        // // Créez un sous-dossier unique pour chaque eBook en utilisant son ID
        // $ebookImageDirectory = $imageDirectory . 'ebook_' . $ebook->getId() . '/';

        // // Vérifiez si le répertoire du livre existe déjà, sinon, créez-le
        // if (!is_dir($ebookImageDirectory)) {
        //     mkdir($ebookImageDirectory, 0777, true);
        // }

        // // Vérifiez si le répertoire contient déjà des images ou non
        // if (count(glob($ebookImageDirectory . '*')) === 0) {
        //     // Le répertoire est vide, extrayez les images
        //     $pdf = new Pdf('uploads/ebook/' . $ebook->getPdf());
        //     $numberOfPages = $pdf->getNumberOfPages();
        //     $images = [];

        //     for ($pageNumber = 1; $pageNumber <= $numberOfPages; $pageNumber++) {
        //         $imagePath = 'ebook-images/ebook_' . $ebook->getId() . '/page_' . $pageNumber . '.jpg';
        //         $pdf->setPage($pageNumber)->saveImage($ebookImageDirectory . 'page_' . $pageNumber . '.jpg');

        //         // Réduire la taille de l'image (facultatif)
        //         $image = Image::make($ebookImageDirectory . 'page_' . $pageNumber . '.jpg');
        //         $image->resize(800, 800); // Ajustez la taille de l'image selon vos besoins
        //         $image->save($ebookImageDirectory . 'page_' . $pageNumber . '.jpg');

        //         $images[] = $imagePath;
        //     }
        // } else {
        //     // Le répertoire contient déjà des images, utilisez-les
        //     $imageFiles = scandir($ebookImageDirectory);
        //     $imageFiles = array_diff($imageFiles, ['.', '..']);
        //     $images = [];

        //     foreach ($imageFiles as $fileName) {
        //         $images[] = 'ebook-images/ebook_' . $ebook->getId() . '/' . $fileName;
        //     }
        // }
