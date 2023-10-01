<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $regularUser = new User();
        $regularUser
        ->setEmail('bobby@bob.com')
        ->setPassword($this->hasher->hashPassword($regularUser, 'test'))
        ->setFirstname('Bobby')
        ->setLastname('Brown')
        ->setPicture('https://via.placeholder.com/640x480.png/00ee33?text=rerum')
        ->setRoles(['ROLE_USER']);
        
        $manager->persist($regularUser);

        $adminUser = new User();
        $adminUser
        ->setEmail('admin@mycorp.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->hasher->hashPassword($adminUser, 'test'))
        ->setFirstname('Marie')
        ->setLastname('Curie')
        ->setPicture('https://via.placeholder.com/640x480.png/00ee33?text=rerum');

  $manager->persist($adminUser);


        $manager->flush();
    }
}
