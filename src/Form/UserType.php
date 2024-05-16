<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Nom de famille requis',
                    ]),

                    new Length([
                        'min' => 2,
                        'max' => 80,
                        'minMessage' => 'Pas assez de caractères',
                        'maxMessage' => 'Pas assez de caractères',
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Prénom requis',
                    ]),

                    new Length([
                        'min' => 2,
                        'max' => 80,
                        'minMessage' => 'Pas assez de caractères',
                        'maxMessage' => 'Pas assez de caractères',
                    ]),
                ],
            ])
            ->add('birthday', DateType::class, [
                'empty_data' => null,
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Date de naissance requise',
                    ]),
                    // new Date([
                    //     'message' => 'Date de naissance invalide',
                    // ])
                ],
            ])
            ->add('email', EmailType::class, [
                'help' => 'Veuillez choisir un email valide',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Email requis',
                    ]),
                    new Email([
                        'message' => 'Email invalide',
                    ])
                ]
            ])
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Mot de pass requis',
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 60,
                        'minMessage' => 'Le mot de passe doit contenir au moins 8 caractères',
                        'maxMessage' => 'Le mot de passe ne doit pas depasser 60 caractères',
                    ])
                ]
            ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('createdAt', HiddenType::class)
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Adresse requis',
                    ]),

                    new Length([
                        'min' => 2,
                        'max' => 180,
                        'minMessage' => 'Pas assez de caractères',
                        'maxMessage' => 'Pas assez de caractères',
                    ]),
                ],
            ])
            ->add('zipCode', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Code postal requis',
                    ]),

                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'minMessage' => 'Pas assez de caractères',
                        'maxMessage' => 'Pas assez de caractères',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Nom de votre ville requis',
                    ]),

                    new Length([
                        'min' => 2,
                        'max' => 20,
                        'minMessage' => 'Pas assez de caractères',
                        'maxMessage' => 'Pas assez de caractères',
                    ]),
                ],
            ])
            ->add('country', CountryType::class)
            // ->add('role', ChoiceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
