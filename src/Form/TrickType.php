<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Nom de la figure',
                ],
            ])
            ->add('content', TextType::class, [
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Description de votre figure',
                ],
            ])
            ->add('grouptrick')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
