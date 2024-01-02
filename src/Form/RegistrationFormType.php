<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez renseigner votre email.']),
            ],
        ])
        ->add('fullname', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Ce champ est obligatoire.']),
            ],
        ])
        ->add('phone', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Ce champ est obligatoire.']),
            ],
        ])
        ->add('deliveryaddress', TextType::class, [
            'required' => false,
        ])
        ->add('billingaddress', TextType::class, [
            'required' => false,
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'Veuillez accepter les termes.',
                ]),
            ],
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Password',
                'constraints' => [
                    new NotBlank(['message' => 'Ce champ est obligatoire.']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ 6 }} caractères.',
                        'max' => 22,
                    ]),
                ],
            ],
            'second_options' => [
                'label' => 'Répéter le mot de passe',
                'constraints' => [
                    new NotBlank(['message' => 'Ce champ est obligatoire.']),
                ],
            ],
        ])
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Client' => 'ROLE_USER',
                'Fournisseur' => 'ROLE_SUPPLIER',
            ],
            'expanded' => true,
            'multiple' => true,
        ]);
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class'  => User::class,
    ]);
}
}