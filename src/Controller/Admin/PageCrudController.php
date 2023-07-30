<?php
// src/Controller/Admin/PageCrudController.php
// src/Controller/Admin/PageCrudController.php

namespace App\Controller\Admin;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\String\Slugger\SluggerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField; // Import CollectionField class

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
        yield TextField::new('slug')->setLabel('Slug')->hideOnForm();
        yield TextEditorField::new('content')->setLabel('Contenu');
        yield AssociationField::new('posts')
        ->setLabel('Posts')
        ->setFormTypeOption('by_reference', false)
        ->setRequired(true)
        ->formatValue(
            function ($value, $entity) {
                $posts = $entity->getPosts();
                $titles = [];
    
                foreach ($posts as $post) {
                    $titles[] = $post->getTitle();
                }
    
                return implode(', ', $titles);
            }
        );
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Page) {
            $this->computeSlug($entityInstance); // Compute the slug before persisting the entity
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    private function computeSlug(Page $page)
    {
        $slug = $this->slugger->slug((string) $page->getTitle())->lower();
        $page->setSlug($slug);
    }
}
