<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Entity\Image;
use App\Entity\EbookImage;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    { 
        yield TextField::new('title', "Titre ");
        yield ImageField::new('path')
            ->setLabel('Image')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads/')
            ->setFormTypeOptions([
                'required' => true,
                'data_class' => null,
            ])
            ->setUploadedFileNamePattern('[uuid].[extension]')
            ->setRequired(true);
        yield DateTimeField::new('created_at', "Ajouté le ")
        ->hideWhenCreating()
        ->hideOnForm()
        ->renderAsChoice();
        yield AssociationField::new('page', 'Page')
        ->setFormType(EntityType::class, [
            'class' => Page::class,
            'choice_label' => 'title', // Display page titles in the dropdown
            'placeholder' => 'Select a page', // Optional: Add a placeholder
            'required' => false, // Make it optional if needed
        ])
        ->setLabel('Page');
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
