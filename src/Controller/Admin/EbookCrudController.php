<?php

namespace App\Controller\Admin;

use App\Entity\Ebook;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Storage\FileSystemStorage;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Vich\UploaderBundle\Form\Type\VichFileType;
// use App\Service\PdfImageExtractor;
class EbookCrudController extends AbstractCrudController
{
    // private $pdfImageExtractor;
    // private $uploaderHelper;

    // public function __construct(PdfImageExtractor $pdfImageExtractor, UploaderHelper $uploaderHelper)
    // {
    //     $this->pdfImageExtractor = $pdfImageExtractor;
    //     $this->uploaderHelper = $uploaderHelper;
    // }

    public static function getEntityFqcn(): string
    {
        return Ebook::class;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //         ->setEntityLabelInSingular('Ebook')
    //         ->setEntityLabelInPlural('Ebooks')
    //         ->setSearchFields(['title', 'author']);
    // }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel('Titre');
        yield TextField::new('author')
            ->setLabel('Auteur');
        yield TextEditorField::new('description')
            ->setLabel('Description');
        yield Field::new('pdfFile','Ebook {Pdf Exclusivement}')
            ->setFormType(VichFileType::class);
    }


    // public function uploadEbook(Request $request, FileSystemStorage $storage): Response
    // {
    //     $ebook = new Ebook();

    //     $form = $this->createFormBuilder($ebook)
    //         ->add('fileObj', VichFileType::class)
    //         ->getForm();

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $uploadedFile = $ebook->getFileObj();

    //         if ($uploadedFile) {
    //             $storage->upload($uploadedFile, $ebook, 'fileObj');

    //             if ($uploadedFile->getClientOriginalExtension() === 'pdf') {
    //                 $pdfPath = $this->uploaderHelper->asset($ebook, 'fileObj');
    //                 $images = $this->pdfImageExtractor->extractImages($pdfPath);

    //                 // Faites ce que vous voulez avec les images (par exemple, enregistrez les chemins d'accès dans l'entité Ebook)
    //                 foreach ($images as $imagePath) {
    //                     // Ajoutez ici votre logique pour enregistrer les chemins d'accès des images dans l'entité Ebook
    //                 }
    //             }
    //         }

    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($ebook);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('admin_ebook_index');
    //     }

    //     return $this->render('admin/ebook/upload.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
}