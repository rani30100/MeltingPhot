<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
 
        return [
            // IdField::new('id')
            //     ->hideOnDetail(),
            TextField::new('username')
            ->setLabel("Nom d'utilisateur"),
            TextField::new('email')
            ->formatValue(function ($value, $entity) {
                return $value;
            }),
            ChoiceField::new('roles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                ])
                //partie pour stringify le tableau 
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('expanded', true)
                ->setFormTypeOption('choice_attr', [
                    'User' => ['data-role' => 'ROLE_USER'],
                    'Admin' => ['data-role' => 'ROLE_ADMIN'],
                    'Super Admin' => ['data-role' => 'ROLE_SUPER_ADMIN'],
                ]),
                BooleanField::new('isVerified')
                ->setLabel('Est vérifié')
        ];
    }

}
