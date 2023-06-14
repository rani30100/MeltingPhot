<?php

namespace App\Controller\Admin;

use App\Entity\Business;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Google\Client as GoogleClient;

class BusinessCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Business::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('category'),
            // Add more fields as needed
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Business')
            ->setEntityLabelInPlural('Businesses')
            ->setPageTitle('index', 'Manage Businesses')
            ->setPageTitle('new', 'Create New Business')
            ->setPageTitle('edit', 'Edit Business')
            ->setPageTitle('detail', 'Business Details');
    }
}
