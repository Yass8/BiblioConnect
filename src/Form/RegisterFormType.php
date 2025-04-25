<?php

namespace App\Form;


use App\Entity\User;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => "votre email",
                "attr" => [ "class" => "form-control"],
                'required' => true
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            
            ->add('firstname', TextType::class, [
                'label' => "Votre prénom",
                "attr" => [ "class" => "form-control"],
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => "Votre nom",
                "attr" => [ "class" => "form-control"],
                'required' => true
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => "Votre numéro de téléphone",
                "attr" => [ "class" => "form-control"],
                'required' => true
            ])
            ->add('address', TextType::class, [
                'label' => "Votre adresse",
                "attr" => [ "class" => "form-control"],
                'required' => true
            ])
            ->add("inscription", SubmitType::class,[
                "attr" => [ "class" => "form-control btn btn-info mt-2"]
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
