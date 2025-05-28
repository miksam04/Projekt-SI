<?php

/**
 * User type.
 */

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Options Form options
     *
     * @return void returns nothing
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nickname',
                TextType::class,
                [
                    'label' => 'Nickname',
                    'attr' => [
                        'required' => true,
                        'placeholder' => 'Enter nickname',
                        'max_length' => 20,
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'attr' => [
                        'required' => true,
                        'placeholder' => 'Enter email',
                        'max_length' => 180,
                    ],
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label' => 'Password',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Enter new password (optional)',
                        'max_length' => 255,
                    ],
                ]
            );
    }

    /**
     * Configure options.
     *
     * @param OptionsResolver $resolver Options resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
