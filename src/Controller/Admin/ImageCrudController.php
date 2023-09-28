<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Entity\Image;
use Twig\Environment;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController
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
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    { 
        yield AssociationField::new('user', 'Utilisateur')
        ->setLabel('Utilisateur')
        ->setCustomOption('user', $this->security->getUser()) // Passer l'utilisateur actuel au champ
        ->hideOnForm(); // Cacher le champ dans le formulaire

        yield TextField::new('title', "Titre ");

        yield ImageField::new('path', 'Image')
        ->setBasePath('img/')
        ->setUploadDir('public/img/')
        // ->setFormType(VichImageType::class)
        ->setLabel('Image');
    
        yield DateTimeField::new('created_at', "Ajouté le ")
        ->hideWhenCreating()
        ->hideOnForm()
        ->renderAsChoice();

        // yield AssociationField::new('page', 'Page')
        // ->setFormType(EntityType::class, [
        //     'class' => Page::class,
        //     'choice_label' => 'title', // Display page titles in the dropdown
        //     'placeholder' => 'Select a page', // Optional: Add a placeholder
        //     'required' => false, // Make it optional if needed
        // ])
        // ->setLabel('Page');
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('created_at')
        ;
    }
   
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
    
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            // Récupérez les données soumises dans le formulaire
            $formData = $event->getData();
            
            // Vérifiez si les données sont une instance de la classe "Image" (votre entité) et si le champ "user" est vide
            if ($formData instanceof Image && !$formData->getUser()) {
                // Récupérez l'utilisateur actuellement authentifié à partir du service "Security"
                $user = $this->security->getUser();
            
                // Remplissez le champ "user" de l'entité "Image" avec l'utilisateur actuel
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
            
            // Vérifiez si les données sont une instance de la classe "Image" (votre entité) et si le champ "user" est vide
            if ($formData instanceof Image && !$formData->getUser()) {
                // Récupérez l'utilisateur actuellement authentifié à partir du service "Security"
                $user = $this->security->getUser();
            
                // Remplissez le champ "user" de l'entité "Image" avec l'utilisateur actuel
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
