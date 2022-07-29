<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagename', FileType::class, [
                'label' => false,

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
//            ->add('videoname', TextType::class, [
//                'label' => false,
//                'attr' => [
//                    'class' =>'form-control rounded-0',
//                    'placeholder' => 'Lien de votre vidéo (youtube)',
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Image::class,
        ]);
    }
}
