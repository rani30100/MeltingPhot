<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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

            TextField::new('password', 'Mot de Passe')
            ->setFormType(PasswordType::class)
            ->setRequired(true)
            ->setColumns(6),
            // ->onlyWhenCreating(),

            ChoiceField::new('roles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Stagiaire' => 'ROLE_INTERN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
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
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Hashage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
        $entityInstance->setPassword($hashedPassword);

        parent::updateEntity($entityManager, $entityInstance);
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            // in addition to a string, the argument of the singular and plural label methods
            // can be a closure that defines two nullable arguments: entityInstance (which will
            // be null in 'index' and 'new' pages) and the current page name
           
            ->setEntityLabelInPlural(function (?User $user, ?string $pageName) {
                return 'edit' === $pageName ? $user->getUserName() : 'Mes utilisateurs';
            })

            // the Symfony Security permission needed to manage the entity
            // (none by default, so you can manage all instances of the entity)
            ->setEntityPermission('ROLE_SUPER_ADMIN')
        ;
    }
}
      

      
