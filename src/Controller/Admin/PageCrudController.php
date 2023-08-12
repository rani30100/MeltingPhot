<?php
// src/Controller/Admin/PageCrudController.php

namespace App\Controller\Admin;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\String\Slugger\SluggerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
        yield TextField::new('slug')->setLabel('/Url')->hideOnForm();
        yield TextEditorField::new('content')->setLabel('Contenu');
        yield AssociationField::new('posts')
            ->setLabel('Posts')
            ->setFormTypeOption('by_reference', false)
            ->setRequired(false);
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
