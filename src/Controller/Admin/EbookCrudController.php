<?php

namespace App\Controller\Admin;

use App\Entity\Ebook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Storage\FileSystemStorage;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Vich\UploaderBundle\Form\Type\VichImageType;

// use App\Service\PdfImageExtractor;
class EbookCrudController extends AbstractCrudController
{

    private $uploaderHelper;

    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

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


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel('Titre');

        yield TextField::new('author')
            ->setLabel('Auteur');

        yield TextField::new('description')
            ->setLabel('Description');
            
            
        yield TextField::new('pdf', 'Lien du Livre Numérique')
        ->setTemplatePath('admin/ebook/pdf_link.html.twig')
        // ->setFormType(VichFileType::class)
        ->hideOnForm()
        ->onlyOnIndex();

        yield Field::new('pdfFile', 'Mon Livre Numérique')
        ->setFormType(VichImageType::class)
        ->setLabel('Livre Numérique')
        ->onlyOnForms(); // Show only on the form, not on the index/list view
        

    }


}