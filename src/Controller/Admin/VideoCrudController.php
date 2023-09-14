<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


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
    
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {

        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $builder
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
              
                $this->addFlash(
                    'success', // Le type du message flash (par exemple, 'success' pour un message de succès)
                    'Les modifications ont été enregistrées avec succès!' // Le message à afficher
                );
            });

        return $builder;
    }
    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {

        $builder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $builder
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
  
                $this->addFlash(
                    'success', // Le type du message flash (par exemple, 'success' pour un message de succès)
                    'Les modifications ont été enregistrées avec succès!' // Le message à afficher
                );
            });

        return $builder;
    }
  
}
