<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
}
