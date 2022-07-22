<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

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
            ->add('media', CollectionType::class, [
                'entry_type' => MediaType::class,
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Ajoutez votre image',
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('image', FileType::class, [
                'label' => false,

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new Image([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Merci d\'ajouter une image au format jpg ou png de maximum 2Mo.',
                    ])
                ],
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
