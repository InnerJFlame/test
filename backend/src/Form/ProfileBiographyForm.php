<?php

declare(strict_types=1);

namespace App\Form;

use App\DBAL\Types\ChestSize;
use App\DBAL\Types\EyeColor;
use App\DBAL\Types\HairColor;
use App\DBAL\Types\YesNo;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProfileBiographyForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'height',
                NumberType::class,
                [
                    'constraints' => [
                        new Assert\Positive(),
                        new Assert\LessThanOrEqual(230),
                    ],
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                [
                    'constraints' => [
                        new Assert\Positive(),
                        new Assert\LessThanOrEqual(230),
                    ],
                ]
            )
            ->add(
                'eyeColor',
                ChoiceType::class,
                [
                    'choices' => EyeColor::getChoices(),
                ]
            )
            ->add(
                'hairColor',
                ChoiceType::class,
                [
                    'choices' => HairColor::getChoices(),
                ]
            )
            ->add(
                'chestSize',
                ChoiceType::class,
                [
                    'choices'            => ChestSize::getChoices(),
                    'translation_domain' => 'messages',
                ]
            )
            ->add(
                'isSmoking',
                ChoiceType::class,
                [
                    'choices' => YesNo::getChoices(),
                ]
            )
            ->add(
                'hasTattoo',
                ChoiceType::class,
                [
                    'choices' => YesNo::getChoices(),
                ]
            )
            ->add(
                'hasPiercings',
                ChoiceType::class,
                [
                    'choices' => YesNo::getChoices(),
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
