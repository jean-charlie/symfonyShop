<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email",
                'required' => true,
                'attr' => [
                    'autofocus' => true
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "J'accepte les conditions d'utilisation du site.",
                    ]),
                ],
            ])
            ->add('fullName', TextType::class, [
                'label' => "Nom complet"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Les mots de passe saisis ne correspondent pas.",
                'required' => true,
                'first_options' => [
                    'label' => "Mot de passe",
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                            'max' => 100,
                        ]),
                        new Regex(
                            '#^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#',
                            'Le mot de passe doit contenir au moins 6 caractères avec au minimum une majuscule,
                            une minuscule et un chiffre'
                        )
                    ],
                ],
                'second_options' => [
                    'label' => "Confirmer le mot de passe",
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                            'max' => 100,
                        ]),
                        new Regex(
                            '#^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#',
                            'Le mot de passe doit contenir au moins 6 caractères avec au minimum une majuscule,
                            une minuscule et un chiffre'
                        )
                    ],
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
