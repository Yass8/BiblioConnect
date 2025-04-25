<?php

namespace App\Form;

use App\Entity\Books;
use App\Entity\Languages;
use App\Entity\Stocks;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StocksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('quantity_reserved')
            ->add('quantity_available')
            ->add('language', EntityType::class, [
                'class' => Languages::class,
                'choice_label' => 'id',
            ])
            ->add('books', EntityType::class, [
                'class' => Books::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stocks::class,
        ]);
    }
}
