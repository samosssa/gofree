<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // categories
        $types = ['informatique', 'publicité', 'communiquation'];

        foreach ($types as $key=>$type) {
            $category = new Category();
            $category->setTitle($type);
            $category->setDescription('lorem ipsum');


            $manager->persist($category);
            $this->addReference('category_' . $key, $category);

            $manager->persist($category);
        }
        $manager->flush();
    }
}
