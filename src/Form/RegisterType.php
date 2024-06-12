<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            // ->add('roles')
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[\W_]).+$/',
                        'message' => 'Your password should contain at least one uppercase letter and one special character',
                    ]),                    
                ],
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your last name',
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your first name',
                    ]),
                ],
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your birthday',
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your address',
                    ]),
                ],
            ])
            ->add('zipCode', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your zip code',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your city',
                    ]),
                ],
            ])
            ->add('country', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your country',
                    ]),
                ],
            ])
            ->add('createdAt', DateType::class, [
                'empty_data' => null,
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter the creation date',
                    ]),
                ],
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