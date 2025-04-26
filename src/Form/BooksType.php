<?php

namespace App\Form;

use App\Entity\Books;
use App\Entity\Author;
use App\Entity\Themes;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('description', TextType::class, [
                "attr" => [ "class" => "form-control"]
            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'fullname',
                "attr" => [ "class" => "form-control"]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                "attr" => [ "class" => "form-control"]
            ])
            ->add('themes', EntityType::class, [
                'class' => Themes::class,
                'choice_label' => 'name',
                "attr" => [ "class" => "form-control"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
