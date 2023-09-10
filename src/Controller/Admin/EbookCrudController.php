<?php

namespace App\Controller\Admin;

use App\Entity\Ebook;
use App\Entity\EbookImage;
use App\Form\Type\EbookImageType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

// use App\Service\PdfImageExtractor;
class EbookCrudController extends AbstractCrudController
{
    private $uploaderHelper;
    private $entityManager;
    
    public function __construct(UploaderHelper $uploaderHelper,EntityManagerInterface $entityManager)
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->entityManager = $entityManager;
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
        // yield IdField::new('id')
        //     ->onlyOnIndex();


        yield TextField::new('author', 'Auteur');
        yield TextField::new('title', 'Titre');
        yield TextField::new('description', 'Description');
        yield CollectionField::new('images')
        ->setEntryType(EbookImageType::class)
        ->allowAdd(true)
        ->allowDelete(true);
    }

  
}