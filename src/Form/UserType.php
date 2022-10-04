<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Votre nom',
                ],
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Votre prénom',
                ],
                'required' => false,
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "label" => false,
                "invalid_message" => "Vos mots de passe ne sont pas identiques.",
                "options" => [
                    'attr' => [
                        'class' => 'password-field',
                    ]
                ],
                'required' => false,
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
            ])
            ->add('mail', EmailType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0',
                    'placeholder' => "Email",
                ],
                'required' => true,
                "constraints" => [
                    new Email(['message' => "Veuillez saisir une adresse email valide. Ex : John.Doe@google.com"]),
                ]
            ])
            ->add('avatar', ChoiceType::class, [
                'choices' => [
                    '1' => "avatar-0",
                    '2' => "avatar-1",
                    '3' => "avatar-2",
                    '4' => "avatar-3",
                    '5' => "avatar-4",
                    '6' => "avatar-5",
                ],
                'attr' => [
                    'class' => 'form-control rounded-0',
                ],
                'expanded' => true,
                'multiple' => false,
                'data' => $options['avatar'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'avatar' => [],
//            'data_class' => User::class,
        ]);
    }
}
