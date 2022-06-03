<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $builder
            ->add('login', TextType::class, [
                'attr' => [
                    'class' => 'form-control rounded-0',
                    'placeholder' => 'Nom d\'utilisateur'
                ],
                "required" => true
            ])
            ->add('password', PasswordType::class, [
                "label" => false,
                "invalid_message" => "Votre mot de passe ne correspond pas.",
                'attr' => [
                    'class' => 'form-control rounded-0',
                    'placeholder' => 'Mot de passe',
                    'required' => true,
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