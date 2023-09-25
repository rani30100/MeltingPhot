<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Newsletter;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewsletterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex(),
            TextField::new('title'),
            TextEditorField::new('description'),
            DateTimeField::new('send_at', 'Envoyer le '),
            BooleanField::new('readyToPrepare', 'Prête à être envoyer ?')
              // ->onlyOnForms()
              ->renderAsSwitch(),

        ];
    }
    
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {

        $builder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $builder
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
  
                // Ajouter un message flash
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

