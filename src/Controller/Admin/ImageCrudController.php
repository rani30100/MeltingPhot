<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    { 
        return [
           
            TextEditorField::new('name'),
            ImageField::new('path')
            ->setLabel('Choisir une Image...')
            ->setBasePath('uploads/') // this is the directory where uploaded images will be stored
            ->setUploadDir('public/uploads/') // this is the directory where uploaded files are temporarily stored during the upload process
            ->setFormTypeOptions([
                'required' => false, // Make the field optional
                'data_class' => null, // Allow any data type for the field
            ])

        ];
    }
    
}
