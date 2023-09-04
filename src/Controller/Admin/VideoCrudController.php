<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;


class VideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Video::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
         
            AssociationField::new('user', 'Utilisateur')
            ->setLabel('Utilisateur'),

            TextField::new('user_id')->hideOnForm(),

            TextField::new('title'),

            DateTimeField::new('created_at')->onlyOnIndex(),

            TextField::new('url'),

            AssociationField::new('category')->autocomplete(),
            
            ImageField::new('Image')
            ->setLabel('Image')
            ->setBasePath('uploads/videos/images') // Chemin de base pour afficher les images
            ->setUploadDir('public/uploads/videos/images') // Dossier de destination pour enregistrer les images
            ->setUploadedFileNamePattern('[name].[extension]') // Modèle de nom de fichier pour les images téléchargées
            ->setRequired(false), // Rendre le champ facultatif si nécessaire
            //COmmentaire
        ];
    }
    
  
}
