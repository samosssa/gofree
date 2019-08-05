<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
        // $product = new Product();
        // $manager->persist($product);

        private $encoder;

        public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
        public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr-FR');

        $adminRole = new Role();
        $adminRole ->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('sam')
            ->setLastName('agd')
            ->setEmail('sam.agd@symf.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setPicture('https://avatars.io/twitter/Samc')
            ->setIntroduction($faker->sentence())
            ->addRole($adminRole);

        $manager->persist($adminUser);

        //nous gérons les utilisateurs
        $users = [];
        $genres= ['male', ' female'];

        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture='https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genres))
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setHash($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }

        // Missions
        for ($i=0;$i<100;$i++) {
            $mission = new Mission();

            $startDate = $faker->dateTimeBetween('-3 months');
            //gestion de la date de fin
            $duration = mt_rand(3, 10);
            $endDate = (clone $startDate)->modify("+$duration days");
            $user = $users[mt_rand(0, count($users) - 1)];
            $coverImage = $faker->imageUrl(1000,350);


            $mission->setTitle($faker->text(30));
            $mission->setCoverImage($coverImage);
            $mission->setStartDay($startDate);
            $mission->setEndDate($endDate);
            $mission->setPrice($faker->randomFloat());
            $mission->setDescription('<p>' .join('<p></p>',$faker->paragraphs(3)) . '</p>');
            $mission->setCategory($this->getReference('category_' . rand(0,2)));
            $mission->setAuthor($user);

            $manager->persist($mission);
            $this->addReference('mission_' . $i, $mission);


        }


        $manager->flush();
    }
}
