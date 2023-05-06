<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserCrudController extends AbstractCrudController
{
    //cette séccurité va permettre de hashe le mdp automatiquement dans la bdd
    // en cas de fuite les données sont protegés
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    
    public static function getEntityFqcn(): string
    { 
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->setColumns(6),
                
            TextField::new('username')
            ->setLabel("Nom d'utilisateur")
            ->setColumns(6),

            TextField::new('email')
            ->formatValue(function ($value, $entity) {
                return $value;
            })
            ->setColumns(6),

            TextField::new('password', 'Mot de Passe')
            ->setFormType(PasswordType::class)
            ->onlyWhenCreating()
            ->setRequired(true)
            ->setColumns(6),

            ChoiceField::new('roles')
                ->setChoices([
                    'User' => '["ROLE_USER"]',
                    'Admin' => '["ROLE_ADMIN"]',
                    'Super Admin' => '["ROLE_SUPER_ADMIN"]',
                ])
                ->allowMultipleChoices()
                ->setColumns(6),
    
            BooleanField::new('isVerified')
            ->setLabel('Est vérifié')
            ->setColumns(6),
            // ImageField::new('imageFilename', 'Photos')->setFormType(FileUploadType::class)->setUploadDir('public/uploads')->setColumns(6),
          
        
    
        ]; 
    }
      
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Hashage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
        $entityInstance->setPassword($hashedPassword);
    
        parent::persistEntity($entityManager, $entityInstance);
    }
    

    
    
}
      
