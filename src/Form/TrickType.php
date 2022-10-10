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
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Valid;

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
                'label' => false,
                'allow_delete' => true,
                'constraints' => [
                    new Count(min: 1, max: 3, minMessage: 'Vous devez ajouter au moins une image.',
                        maxMessage: 'Vous ne pouvez pas ajouter plus de 3 images.', groups: ['trick_new', 'trick_edit']),
                    new Valid(),
                ],
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Ajoutez votre vidéo',
                ],
                'by_reference' => false,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'constraints' => [
                    new Count(min: 1, max: 3, minMessage: 'Vous devez ajouter au moins une vidéo.',
                        maxMessage: 'Vous ne pouvez pas ajouter plus de 3 vidéos.', groups: ['trick_new', 'trick_edit']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'validation_groups' => [],
        ]);
    }
}
