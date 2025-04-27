<?php

namespace App\Form;

use App\Entity\Books;
use App\Entity\Stocks;
use App\Entity\Languages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StocksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('language', EntityType::class, [
                'class' => Languages::class,
                'choice_label' => 'name',
                    "attr" => [ "class" => "form-control"]
            ])
            ->add('books', EntityType::class, [
                'class' => Books::class,
                'choice_label' => 'title',
                    "attr" => [ "class" => "form-control"]
            ])
            ->add('quantity', IntegerType::class, [
                "attr" => [ "class" => "form-control", "min"=>0]
            ])
            // ->add('quantity_reserved', IntegerType::class, [
            //     "attr" => [ "class" => "form-control", "min"=>0]
            // ])
            // ->add('quantity_available', IntegerType::class, [
            //     "attr" => [ "class" => "form-control", "min"=>0]
            // ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stocks::class,
        ]);
    }
}
