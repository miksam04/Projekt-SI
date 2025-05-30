<?php

/**
 * RegistrationType class.
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

/**
 * Class RegistrationType.
 *
 * This class defines the form type for user registration.
 */
class RegistrationType extends AbstractType
{
    /**
     * Configure options for the form.
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Options for the form
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
                    'required' => true,
                    'mapped' => false,
                    'attr' => [

                        'placeholder' => 'Enter password',
                        'max_length' => 255,
                    ],
                ]
            );
    }

    /**
     * Configure options for the form.
     *
     * @param OptionsResolver $resolver Options resolver
     *
     * @return void returns nothing
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
