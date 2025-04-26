<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Books;
use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('status', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('handed_over')
            ->add('books', EntityType::class, [
                'class' => Books::class,
                'choice_label' => 'title',
                    "attr" => [ "class" => "form-control"]
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
                    "attr" => [ "class" => "form-control"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
