<?php

namespace App\Controller\Admin;

use FileField;
use App\Entity\Ebook;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EbookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ebook::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title');
        yield TextField::new('author');
        yield TextEditorField::new('description');
        yield ImageField::new('file')
            ->setBasePath('ebooks') // Chemin de base pour le stockage des fichiers
            ->setUploadDir('public/img/ebooks') // Répertoire de téléchargement des fichiers
            ->setUploadedFileNamePattern('[randomhash].[extension]'); // Modèle de nom de fichier pour le stockage

        
    }
}
