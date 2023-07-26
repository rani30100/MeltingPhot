<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
        yield TextEditorField::new('title');
        yield ImageField::new('path')
            ->setLabel('Choisir une Image...')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads/')
            ->setFormTypeOptions([
                'required' => true,
                'data_class' => null,
            ])
            ->setUploadedFileNamePattern('[uuid].[extension]')
            ->setRequired(true);
        yield DateTimeField::new('created_at')->renderAsChoice();
    }
    
}
