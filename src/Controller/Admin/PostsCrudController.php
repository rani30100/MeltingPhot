<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Posts;
use Twig\Environment;
use App\Twig\PlainTextExtension;
use Google\Service\DriveActivity\Create;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Validator\Constraints as Assert;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostsCrudController extends AbstractCrudController
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
        return Posts::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            
            IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex(),
            TextField::new('title')->setLabel('Titre du Post'),
            TextField::new('description', 'Description'),

            ImageField::new('path', 'Image')

                ->setBasePath('/uploads/post')
                ->setLabel('Image du Post')
                ->onlyOnIndex(),

                AssociationField::new('user', 'Utilisateur')
                ->setLabel('Utilisateur')
                ->setCustomOption('user', $this->security->getUser()), // Pass the user to the field
                // ->onlyOnIndex(),
          

                // ImageField::new('imageFile', 'Image')
                // ->setFormType(VichImageType::class)
                // ->setFormTypeOptions([
                //     'upload_dir' => 'uploads/post/images',
                //     'required' => false, // Optional: Set it to true, if the field is mandatory.
                // ]),
                TextareaField::new('imageFile')
                ->setFormType(VichFileType::class)
                ->onlyOnForms(),
                
                
            

            Field::new('video', 'Fichier Vidéo')
                ->setFormType(DropzoneType::class)
                ->setFormTypeOptions([
                    'required' => false, // Set initial value as false
                ])
                ->setHelp('Glisser une vidéo dans le champ')
                ->onlyOnForms()
                ->hideOnIndex(),

            TextField::new('videoUrl', 'Url Vidéo')
                ->setFormType(TextType::class) // Use TextType instead of TextField here
                ->setFormTypeOptions([
                    'required' => false, // Set initial value as false
                ])
                ->onlyOnForms()
                ->hideOnIndex(),

            // TextField::new('position')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Date de Création ')
            ->hideWhenCreating()
            ->hideWhenUpdating(),
            
            DateTimeField::new('updatedAt','Date de Modification')
            ->hideOnForm()
            ->hideWhenCreating(),
    
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('user')           
            ->add('createdAt')
            ->add('updatedAt')
        

            
        ;
    }

  


}
