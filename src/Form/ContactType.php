<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Nom', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z\s]*$/',
                    'message' => 'Le nom ne doit contenir que des lettres et des espaces.'
                ])
                ],
                //Pour les classes
                'attr' => ['class' => ''],
                'label'=> false,
        ])
        ->add('email', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email([
                    'message' => 'L\'adresse email "{{ value }}" n\'est pas valide.'
                ])
                ],
            'attr'=>['class' => ''],
            'label'=> false,
        ])
        ->add('Subject', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez entrer un sujet.',
                ]),
            ],
            'label'=> false,
            'attr'=>['class' => ''],
        ])
        ->add('Message', TextareaType::class, [
            'constraints' => [
                new Assert\NotBlank(),
            ],
            'label'=> false,
            'attr'=>['class' => 'contact-input contact-Message ', 'style' => 'width: 50%;margin:40px auto;'],
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr'=>['class' => 'send-btn'],
        ])
        ->add('piege', TextType::class, [
            'mapped' => false,
            'constraints' => [
                new Assert\Blank(),
            ],
            'required' => false,
            'attr' => [
                'style' => 'display:none;',

            ],
            'label' => '',
        ])
        ;
    }
 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
