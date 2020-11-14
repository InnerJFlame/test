<?php

declare(strict_types=1);

namespace App\Form;

use App\DBAL\Types\UserRole;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'required'      => true,
                    'type'          => PasswordType::class,
                    'property_path' => 'plainPassword',
                    'first_name'    => 'password',
                    'second_name'   => 'repeat',
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => [
                        UserRole::ROLE_CLIENT => UserRole::ROLE_CLIENT,
                        UserRole::ROLE_ESCORT => UserRole::ROLE_ESCORT,
                    ],
                ]
            );

        $builder->get('roles')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($tagsAsArray) {
                        return is_null($tagsAsArray) ? null : implode(', ', $tagsAsArray);
                    },
                    function ($tagsAsString) {
                        return is_null($tagsAsString) ? null : explode(', ', $tagsAsString);
                    }
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'        => User::class,
                'validation_groups' => ['SignUp'],
            ]
        );
    }
}
