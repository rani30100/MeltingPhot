<?php

namespace App\Controller\Admin;

use App\Entity\Ebook;
use App\Admin\DragDropFileType;
use Symfony\Component\Form\FormTypeInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;



class EbookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ebook::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel('Titre');

        yield TextEditorField::new('description')
            ->setLabel('Description');

            yield $this->createDragDropFileField('file', 'Fichier PDF');
        }
    
        private function createDragDropFileField(string $propertyName, string $label): FieldInterface
        {
            return Field::new($propertyName, $label)
                ->setFormType(DragDropFileType::class);
        }
    }