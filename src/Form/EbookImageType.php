<?php

namespace App\Form\Type;


use App\Entity\Ebook;
use App\Entity\EbookImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


// ...

class EbookImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Vous devez utiliser un champ permettant de sélectionner un Ebook auquel attacher une image
        $builder
            ->add('ebook', HiddenType::class)
            ->add('imageName', FileType::class, [
                'label' => 'Image', // Le libellé du champ
                'multiple' => false, // Vous pouvez spécifier 'true' si vous autorisez plusieurs images par EbookImage
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}

    


