<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Books;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Languages;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BooksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // On prépare quelques catégories et langues d'abord
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $categories[] = $category;
        }

        $languages = [];
        foreach (['Français', 'Anglais', 'Espagnol', 'Allemand'] as $langName) {
            $language = new Languages();
            $language->setName($langName);
            $manager->persist($language);
            $languages[] = $language;
        }

        for ($i = 0; $i < 20; $i++) {
            $author = new Author();
            $author->setFullname($faker->name);
            $manager->persist($author);

            $book = new Books();
            $book->setTitle($faker->sentence(3));
            $book->setAuthor($author);
            $book->setCategory($faker->randomElement($categories));
            $book->setLanguage($faker->randomElement($languages));
            $book->setDescription($faker->paragraph(4));
            $book->setStock($faker->numberBetween(1, 10));

            $manager->persist($book);
        }

        $manager->flush();
    }
}
