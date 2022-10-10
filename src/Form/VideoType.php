<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('videoname', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' =>'form-control rounded-0',
                    'placeholder' => 'Lien de votre vidéo (youtube)',
                ],
                'constraints' => [
                    new NotNull(message: 'Ne laissez pas un champ vide.', groups: ['trick_new', 'trick_edit']),
                    new Regex(
                        pattern: "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/",
                        message: 'Merci d\'ajouter une url provenant de Youtube.',
                        match: true,
                        groups: ['trick_new', 'trick_edit'],
                    )
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
            'validation_groups' => [],
        ]);
    }
}
