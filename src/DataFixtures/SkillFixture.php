<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SkillFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // categories
        $types = ['diplome', 'éxpérience', 'motivation'];

        foreach ($types as $key=>$type) {
            $skill = new Skill();
            $skill->setTitle($type);
            $skill->setDescription('lorem ipsum');


            $manager->persist($skill);
            $this->addReference('skill_' . $key, $skill);

            $manager->persist($skill);
        }
        $manager->flush();
    }



}
