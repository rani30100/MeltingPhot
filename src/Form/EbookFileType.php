<?php

namespace App\Form;

use App\Entity\Ebook;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EbookFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file', VichFileType::class, [
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '300M', // Limite de poids maximale (300 Mo)
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                ]),
            ],
        ])
            ->add('title', TextType::class,[
                'label'=> 'Titre',
            ])
            ->add('author', TextType::class,[
                'label'=> 'Auteur',
            ])
            ->add('description', TextType::class,[
                'label'=> 'Description',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ebook::class,
        ]);
    }
}