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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0',
                    'placeholder' => 'Nom d\'utilisateur'
                ],
                "required" => true
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "label" => false,
                "invalid_message" => "Vos mots de passe ne sont pas identiques.",
                "options" => [
                    'attr' => [
                        'class' => 'password-field',
                        'required' => true,
                    ]
                ],
                "first_options" => [
                    'attr' => [
                        'class' => ' form-control rounded-0',
                        'placeholder' => "Mot de passe",
                    ],
                    "label" => false,
                ],
                "second_options" => [
                    'attr' => [
                        'class' => ' form-control rounded-0',
                        'placeholder' => "Répetez votre mot de passe",0
                    ],
                    "label" => false,
                ],
                "constraints" => [
                    new NotBlank(['message' => "Ce champ ne peut pas être vide."]),
                    new Length(['min' => 6, 'minMessage' => "Votre mot de passe doit contenir au moins 6 caractères.",
                                'max' => 50, 'maxMessage' => "Votre mot de passe doit avoir moins de 50 caractères."])
                ]
            ])
            ->add('mail', EmailType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0',
                    'placeholder' => "Email",
                ],
                "required" => true,
            ])
            ->add('isAcceptedTerms', CheckboxType::class, [
                'required' => false,
                'label' => false,
                'value' => 0,
                'constraints' => [
                    new NotBlank(['message' => "Merci de prendre connaissance de nos mentions légales et de les accepter."])
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
