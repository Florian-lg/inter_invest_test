<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EmailType::class, [
                'required' => true,
                'label' => 'Email'
            ])
            ->add('password', PasswordType::class, [
                'required' => true,
                'label' => 'Mot de passe'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Connexion'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id' => 'authenticate',
        ));
    }
}