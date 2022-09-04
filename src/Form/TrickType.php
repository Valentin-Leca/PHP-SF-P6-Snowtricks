<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Nom de la figure',
                ],
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Description de votre figure',
                ],
            ])
            ->add('grouptrick', EntityType::class, [
                'class' => Group::class,
                'label_attr' => [
                    'class' => "label_trick_grouptrick"
                ],
                'label' => "Catégorie",

            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Ajoutez votre image',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => true,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Ajoutez votre vidéo',
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
