<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use Twig\Environment;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VideoCrudController extends AbstractCrudController
{

    private Environment $twig;
    private Security $security; // Inject the Security service

    // Inject the Twig Environment and Security service using constructor injection
    public function __construct(Environment $twig, Security $security)
    {
        $this->twig = $twig;
        $this->security = $security;
    }
    
    public static function getEntityFqcn(): string
    {
        return Video::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()
            ->hideOnIndex(),
         
            AssociationField::new('user', 'Utilisateur')
            ->setLabel('Utilisateur')
            ->setCustomOption('user', $this->security->getUser()) // Passer l'utilisateur actuel au champ
            ->hideOnForm(), // Cacher le champ dans le formulaire

            TextField::new('user_id')->hideOnForm()
            ->hideOnIndex(),

            TextField::new('title')
            ->setLabel('Titre de la video')
            ,

            DateTimeField::new('created_at','Ajoutée le ')->onlyOnIndex(),

            TextField::new('url'),

            AssociationField::new('category')
            ->setLabel('Catégorie')
            ->autocomplete(),
            
            ImageField::new('Image')
            ->setLabel('Image')
            ->setBasePath('uploads/videos/images/') // Chemin de base pour afficher les images
            ->setUploadDir('public/uploads/videos/images') // Dossier de destination pour enregistrer les images
            ->setUploadedFileNamePattern('[name].[extension]') // Modèle de nom de fichier pour les images téléchargées
            ->setRequired(false), // Rendre le champ facultatif si nécessaire
            //COmmentaire
        ];
    }
    
 
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
    
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            // Récupérez les données soumises dans le formulaire
            $formData = $event->getData();
            // if (!$formData->getImage()) {
            //     // Si aucune image n'est spécifiée, définissez l'image par défaut
            //     $formData->setImage('img/uploads/videos/images/default_image.png');
            // }
            // Vérifiez si les données sont une instance de la classe "Video" (votre entité) et si le champ "user" est vide
            if ($formData instanceof Video && !$formData->getUser()) {
              
                // Récupérez l'utilisateur actuellement authentifié à partir du service "Security"
                $user = $this->security->getUser();
            
                // Remplissez le champ "user" de l'entité "Video" avec l'utilisateur actuel
                $formData->setUser($user);
            }
            
            // Ajoutez un message flash de succès pour informer l'utilisateur que les modifications ont été enregistrées avec succès
            $this->addFlash(
                'success',
                'Les modifications ont été enregistrées avec succès!'
            );
        });
        
    
        return $builder;
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {

        $builder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            // Récupérez les données soumises dans le formulaire
            $formData = $event->getData();
            if (!$formData->getImage()) {
                // Si aucune image n'est spécifiée, définissez l'image par défaut
                // $formData->setImage('img/uploads/videos/images/default_image.png');
            }
            // Vérifiez si les données sont une instance de la classe "Video" (votre entité) et si le champ "user" est vide
            if ($formData instanceof Video && !$formData->getUser()) {
                // Récupérez l'utilisateur actuellement authentifié à partir du service "Security"
                $user = $this->security->getUser();
            
                // Remplissez le champ "user" de l'entité "Video" avec l'utilisateur actuel
                $formData->setUser($user);
            }
            
            // Ajoutez un message flash de succès pour informer l'utilisateur que les modifications ont été enregistrées avec succès
            $this->addFlash(
                'success',
                'Les modifications ont été enregistrées avec succès!'
            );
        });

        return $builder;
    }
    
  
}
