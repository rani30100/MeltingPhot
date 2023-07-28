<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Posts::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextEditorField::new('description'),
            ImageField::new('imageName')->
            onlyOnForms()
            ->setUploadDir('public/uploads/post') // Define the upload directory for images
            ->setBasePath('/uploads/post'), // Define the base URL for displaying images in the list/show views
            AssociationField::new('user', 'User'),

            Field::new('video', 'Video File')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions([
                    'required' => false, // Set initial value as false
                ])
                ->onlyOnForms()
                ->hideOnIndex(),
            TextField::new('videoUrl', 'Video URL')
                ->setFormType(TextType::class) // Use TextType instead of TextField here
                ->setFormTypeOptions([
                    'required' => false, // Set initial value as false
                ])
                ->onlyOnForms()
                ->hideOnIndex(),

                

            TextField::new('position')->onlyOnForms(),
            DateTimeField::new('createdAt')->onlyWhenCreating(),
            DateTimeField::new('updatedAt')->onlyWhenUpdating(),
            TextField::new('position')->onlyOnForms(),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('updatedAt')->onlyOnDetail(),

                TextField::new('position')->onlyOnForms(),
                DateTimeField::new('createdAt')->onlyOnDetail(),
                DateTimeField::new('updatedAt')->onlyOnDetail(),
        ];
    }

}
