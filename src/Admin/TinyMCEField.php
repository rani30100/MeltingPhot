<?php

declare(strict_types=1);

namespace App\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;

class TinyMCEField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/tinymce')
            ->setTemplatePath('admin/field/tinymce.html.twig')
            ->setFormType(TextareaType::class)
            ->addCssClass('field-tinymce')
            ->setDefaultColumns('col-12');
    }
}
