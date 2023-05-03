<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Video;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $options['current_user'];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('created_at', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'data' => new DateTimeImmutable(),
                'input' => 'datetime_immutable',
                'label' => "Ajouté le ",

            ])
            ->add('url')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'data' => $currentUser,
                'label' => 'Utilisateur',
            ])
            ->add('category');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
        $resolver->setRequired('current_user');
    }
}
