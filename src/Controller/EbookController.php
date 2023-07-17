<?php

namespace App\Controller;

use App\Entity\Ebook;
use App\Form\EbookFileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EbookController extends AbstractController
{
    #[Route('/ebook', name: 'admin_ebook_upload')]
    public function upload(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ebook = new Ebook();
        $form = $this->createForm(EbookFileType::class, $ebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $file */
            $file = $form->get('file')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('ebook_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors du téléchargement du fichier.');
                    return $this->redirectToRoute('admin_ebook_upload');
                }

                // Mettez à jour la propriété filePath de l'entité Ebook avec le nom du fichier
                $ebook->setFile($newFilename);
            }

            $entityManager->persist($ebook);
            $entityManager->flush();

            $this->addFlash('success', 'L\'ebook a été téléchargé avec succès !');

            return $this->redirectToRoute('admin_ebook_show', ['id' => $ebook->getId()]);
        } else {
            $this->addFlash('danger', 'Le formulaire n\'est pas valide.');
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('danger', $error->getMessage());
            }
        }

        return $this->render('ebook/index.html.twig', [
            'ebookForm' => $form->createView(),
        ]);
    }

    #[Route('/ebook/{id}', name: 'admin_ebook_show')]
    public function show(Ebook $ebook): Response
    {
        // Code pour afficher les détails de l'ebook

        return $this->render('ebook/show.html.twig', [
            'ebook' => $ebook,
        ]);
    }
}
