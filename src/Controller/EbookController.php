<?php

namespace App\Controller;

use App\Entity\Ebook;

use setasign\Fpdi\Fpdi;
use App\Form\EbookFileType;
use setasign\Fpdi\PdfParser\PdfParser;
use Doctrine\ORM\EntityManagerInterface;
use setasign\Fpdi\PdfParser\StreamReader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Handler\UploadHandler;
//pour stocker les img dans un tableau
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\UploadHandlerInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class EbookController extends AbstractController
{
    private UploadHandler $uploadHandler;
    private UploaderHelper $uploaderHelper;


    public function __construct(UploadHandler $uploadHandler, UploaderHelper $uploaderHelper)
    {
        $this->uploadHandler = $uploadHandler;
        $this->uploaderHelper = $uploaderHelper;
      
    }
    

    #[Route('/admin/ebook/upload', name: 'admin_ebook_upload')]
    public function upload(Request $request, EntityManagerInterface $entityManager,UploadHandler $uploadHandler): Response
    {
        $ebook = new Ebook();
        $form = $this->createForm(EbookFileType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $ebook->getFile();
            
            if ($file) {
                $uploadHandler->upload($ebook, 'file');
            }
            // Gérez le téléchargement du fichier avec VichUploaderBundle
            // Utilisez le service UploadHandlerInterface pour gérer le téléchargement du fichier
            $this->uploadHandler->upload($ebook, 'file');
  
      

            // Enregistrez l'ebook en base de données
            $entityManager->persist($ebook);
            $entityManager->flush();

            $this->addFlash('success', 'L\'ebook a été téléchargé avec succès !');

            return $this->redirectToRoute('admin_ebook_show', ['id' => $ebook->getId()]);
            } else {
               $this->addFlash('danger', 'Le formulaire n\'est pas valide.');
            }
        // ...

        return $this->render('ebook/index.html.twig', [
            'ebookForm' => $form->createView(),
        ]);
    }

}