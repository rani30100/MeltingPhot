<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            'label' => 'label.name',
            'attr' => [
                'placeholder' => 'placeholder.name',
            ],
        ])

            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'placeholder.email',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "Le champ email ne peut pas être laissé vide.",
                    ]),
                    new Email([
                        'message' => 'Entrez une adresse email valide.',
                    ]),
                ],
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "Accepter les termes d'utilisation ",
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez accepeter les termes d'utilisation.",
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'label.password',
                'attr' => [
                    'placeholder' => 'placeholder.password',
                    'autocomplete' => 'new-password',
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
