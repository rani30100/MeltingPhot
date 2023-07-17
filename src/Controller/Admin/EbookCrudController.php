<?php

namespace App\Controller\Admin;

use App\Entity\Ebook;
use App\Admin\DragDropFileType;
use Symfony\Component\Form\FormTypeInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use FileField;

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
        yield TextField::new('author')
            ->setLabel('auteur');

        yield TextEditorField::new('description')
            ->setLabel('Description');

        yield Field::new('fileObj')->setFormType(VichImageType::class);
    }
}
