<?php

namespace App\DataFixtures;

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

        $manager->flush();
    }
}
