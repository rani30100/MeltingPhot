<?php

namespace App\Form;

use App\Entity\Ebook;
use App\Entity\EbookImage;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EbookImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageName', FileType::class, [
                'label' => 'Image', // Le libellé du champ
                'multiple' => false, // Vous pouvez spécifier 'true' si vous autorisez plusieurs images par EbookImage
            ]);
    }


    public function setOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
