<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 2; $i++) {
            $category = new Category();
            $category->setName('category '.$i);
            $this->addReference('category '.$i , $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}