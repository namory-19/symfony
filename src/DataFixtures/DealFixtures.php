<?php

namespace App\DataFixtures;

use App\Entity\Deal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DealFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 4; $i++) {
            $deal = new Deal();
            $deal->setName('deal '.$i);
            $deal->setDescription('description deal '.$i);
            $deal->setPrice(mt_rand(10,100));
            $deal->setEnable(1);
            $deal->addCategory($this->getReference('category ' .rand(0,1)));
            $manager->persist($deal);
        }
        $manager->flush();
        $this->addReference('deal', $deal);
    }
}