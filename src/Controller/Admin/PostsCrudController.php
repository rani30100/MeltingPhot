<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Posts;
use Twig\Environment;
use App\Twig\PlainTextExtension;
use Google\Service\DriveActivity\Create;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Validator\Constraints as Assert;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostsCrudController extends AbstractCrudController
{
    private Environment $twig;

    // Inject the Twig Environment using constructor injection
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
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
                ->setLabel('Utilisateur'),
          

            Field::new('imageFile', 'Image')->setFormType(VichFileType::class)->onlyOnForms(),

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

            TextField::new('position')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Date de Création ')
            ->hideWhenUpdating(),
            DateTimeField::new('updatedAt','Date de Modification')
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
