<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('lastname', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('phoneNumber', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('address', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('email', EmailType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('password', PasswordType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Bibliothécaire' => 'ROLE_LIBRARIAN',
                ],
                'multiple' => true,
                'expanded' => true,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
