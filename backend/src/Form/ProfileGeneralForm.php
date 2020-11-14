<?php

declare(strict_types=1);

namespace App\Form;

use App\DBAL\Types\ContactMethod;
use App\DBAL\Types\WeekDays;
use App\DBAL\Types\YesNo;
use App\Entity\Area;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\User;
use App\Service\ProfileService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProfileGeneralForm extends AbstractType
{
    /** @var ProfileService $profileService */
    private $profileService;

    /**
     * ProfileGeneralForm constructor.
     *
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\NotNull(),
                    ],
                ]
            )
            ->add(
                'age',
                NumberType::class,
                [
                    'constraints' => [
                        new Assert\GreaterThanOrEqual(18),
                        new Assert\LessThan(100),
                    ],
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'constraints' => [
                        new Assert\Length(
                            [
                                'min' => 10,
                                'max' => 13,
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'country',
                EntityType::class,
                [
                    'class'        => Country::class,
                    'choice_label' => 'name',
                    'choices'      => $this->profileService->getCountryChoices(),
                ]
            )
            ->add(
                'city',
                EntityType::class,
                [
                    'class'        => City::class,
                    'choice_label' => 'name',
                    'choices'      => $this->profileService->getCityChoices(),
                ]
            )
            ->add(
                'area',
                EntityType::class,
                [
                    'class'        => Area::class,
                    'choice_label' => 'name',
                    'choices'      => $this->profileService->getAreaChoices(),
                ]
            )
            ->add('description', TextareaType::class)
            ->add('hasPrivateMessage', ChoiceType::class, $this->yesNoOptions())
            ->add('hasPhotoRotation', ChoiceType::class, $this->yesNoOptions())
            ->add('hasReviews', ChoiceType::class, $this->yesNoOptions())
            ->add(
                'availableDays',
                ChoiceType::class,
                [
                    'choices'  => WeekDays::getChoices(),
                    'expanded' => true,
                    'multiple' => true,
                ]
            )
            ->add(
                'contactMethods',
                ChoiceType::class,
                [
                    'choices'  => ContactMethod::getChoices(),
                    'expanded' => true,
                    'multiple' => true,
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

    /**
     * @return array
     */
    private function yesNoOptions(): array
    {
        return [
            'choices'     => YesNo::getChoices(),
            'choice_attr' => function ($val, $key, $index) {
                return ['class' => 'messages-' . strtolower($index)];
            },
            'expanded'    => true,
        ];
    }
}
