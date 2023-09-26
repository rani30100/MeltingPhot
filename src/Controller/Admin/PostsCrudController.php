<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Posts;
use Twig\Environment;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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

            ImageField::new('path', 'Image')

                ->setBasePath('/uploads/post/images')
                ->setLabel('Image du Post')
                ->onlyOnIndex(),

            AssociationField::new('user', 'Utilisateur')
            ->setLabel('Utilisateur')
            ->setCustomOption('user', $this->security->getUser()) // Passer l'utilisateur actuel au champ
            ->hideOnForm(), // Cacher le champ dans le formulaire

            AssociationField::new('images')
            ->setLabel('Images')
            // ->setCssClass(VichImageType::class)
            ->setFormTypeOption('by_reference', false)
            ->setTemplatePath('admin/imageCrud/custom_image_display.html.twig') // Chemin vers le modèle personnalisé
            ,
        


            Field::new('video', 'Fichier Vidéo')
                ->setFormType(DropzoneType::class)
                ->setFormTypeOptions([
                    'required' => false, // Set initial value as false
                ])
                ->setHelp('Glisser une vidéo dans le champ')
                // ->onlyOnForms(),
                ->hideOnIndex()
                ,

            TextField::new('videoUrl', 'Url Vidéo')
                ->setFormType(TextType::class) // Use TextType instead of TextField here
                ->setFormTypeOptions([
                    'required' => false, // Set initial value as false
                ]),
                // ->onlyOnForms(),
                // ->hideOnIndex(),

            // TextField::new('position')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Date de Création ')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTimeField::new('updatedAt', 'Date de Modification')
                ->hideOnForm()
                ->hideWhenCreating(),

            // ...

            // CollectionField::new('pages', 'Pages associées')
            // ->setLabel('Pages')
            // ->setFormTypeOption('by_reference', false)
            // ->onlyOnForms(),

            AssociationField::new('videoFile')
            ->setLabel('Mes Vidéos')
            ->setTemplatePath('admin/videoCrud/custom_video_display.html.twig') // Chemin vers le modèle personnalisé
            // ->hideOnForm() // Ce champ ne doit pas être modifiable dans le formulaire
            // ->autocomplete() // Permet la recherche d'entités associées
            ->setRequired(false),

            TextAreaField::new('description', 'Description')
                ->addWebpackEncoreEntries('admin')
                ->addCssClass('tinymce')
                ->setFormTypeOption('attr.data-controller', 'tinymce')
                ->setDefaultColumns('12'),

        ];
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('user')
            ->add('createdAt')
            ->add('updatedAt');
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
    
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            // Récupérez les données soumises dans le formulaire
            $formData = $event->getData();
            
            // Vérifiez si les données sont une instance de la classe "Posts" (votre entité) et si le champ "user" est vide
            if ($formData instanceof Post && !$formData->getUser()) {
                // Récupérez l'utilisateur actuellement authentifié à partir du service "Security"
                $user = $this->security->getUser();
            
                // Remplissez le champ "user" de l'entité "Posts" avec l'utilisateur actuel
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
            
            // Vérifiez si les données sont une instance de la classe "Posts" (votre entité) et si le champ "user" est vide
            if ($formData instanceof Post && !$formData->getUser()) {
                // Récupérez l'utilisateur actuellement authentifié à partir du service "Security"
                $user = $this->security->getUser();
            
                // Remplissez le champ "user" de l'entité "Posts" avec l'utilisateur actuel
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

            // ImageField::new('imageFile', 'Image')
            // ->setFormType(VichImageType::class)
            // ->setFormTypeOptions([
            //     'upload_dir' => 'uploads/post/images',
            //     'required' => false, // Optional: Set it to true, if the field is mandatory.
            // ]),
            // TextareaField::new('imageFile')
            //     ->setFormType(VichFileType::class)
            //     ->onlyOnForms(),

            // AssociationField::new('videoFile', 'Fichier Vidéo Intégrer')
            // ->hideOnForm()
            // ->setFormType(DropzoneType::class)
            // ->setFormTypeOptions([
            //     'required' => false, // Set initial value as false
            // ])
            // ->setHelp('Glisser une vidéo dans le champ')
            // ->onlyOnForms(),
            // ->hideOnIndex()
            // ,
