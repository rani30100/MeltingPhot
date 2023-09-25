<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\String\Slugger\SluggerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PageCrudController extends AbstractCrudController
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['title' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')->setLabel('Titre');
        yield TextField::new('slug')->setLabel('/Url');
        yield TextField::new('content')->setLabel('Contenu');
        yield AssociationField::new('posts')
            ->setLabel('Posts')
            ->setFormTypeOption('by_reference', false)
            ->setRequired(false);
        yield AssociationField::new('images')
        ->setLabel('Images')
        ->setCssClass(VichImageType::class)
        ->setTemplatePath('admin/imageCrud/custom_image_display.html.twig'); // Chemin vers le modèle personnalisé
        ;
    
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Page) {
            $this->computeSlug($entityInstance); // Compute the slug before persisting the entity
        }
        $existingPageWithSlug = $entityManager->getRepository(Page::class)->findOneBy(['slug' => $entityInstance->getSlug()]);

        if ($existingPageWithSlug) {
            // Handle the case where the slug is already used, for example, by appending a unique identifier
            $entityInstance->setSlug($this->generateUniqueSlug($entityInstance->getSlug()));
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    private function computeSlug(Page $page)
    {
        $slug = $this->slugger->slug((string) $page->getTitle())->lower();
        $page->setSlug($slug);
    }

    private function generateUniqueSlug(string $slug)
    {
        // Generate a unique slug, for example, by appending a unique identifier
        $uniqueSlug = $slug . '-' . uniqid();

        return $uniqueSlug;
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








