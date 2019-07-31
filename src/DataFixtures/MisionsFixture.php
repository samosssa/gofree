<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MisionsFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');

        // Missions
        for ($i=0;$i<100;$i++) {
            $mission = new Mission();
            $startDate = $faker->dateTimeBetween('-3 months');
            //gestion de la date de fin
            $duration = mt_rand(3, 10);
            $endDate = (clone $startDate)->modify("+$duration days");


            $mission->setTitle($faker->text(30));
            $mission->setStartDay($startDate);
            $mission->setEndDate($endDate);
            $mission->setPrice($faker->randomFloat());
            $mission->setDescription('<p>' .join('<p></p>',$faker->paragraphs(3)) . '</p>');
            $mission->setCategory($this->getReference('category_' . rand(0,2)));

            $manager->persist($mission);
            $this->addReference('mission_' . $i, $mission);


        }

        $manager->flush();
    }
}
