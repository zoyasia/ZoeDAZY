<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use App\Entity\Department;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const CONTRACT_TYPES = ["CDI","CDD","Intérim"];

    private const DEPARTMENTS = ["RH", "Informatique", "Comptabilité", "Direction"];

    private const NB_EMPLOYEES = 15;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $contractTypes = [];
   
        foreach (self::CONTRACT_TYPES as $contractTypeName) {
          $contractType = new ContractType;
          $contractType->setName($contractTypeName);
          $manager->persist($contractType);
          $contractTypes[] = $contractType;
        }

        $departments = [];
        
        foreach (self::DEPARTMENTS as $departmentName) {
            $department = new Department;
            $department->setName($departmentName);
            $manager->persist($department);
            $departments[] = $department;
        }


        $regularUser = new User();
        $regularUser
        ->setEmail('bobby@bob.com')
        ->setPassword($this->hasher->hashPassword($regularUser, 'test'))
        ->setFirstname('Bobby')
        ->setLastname('Brown')
        ->setPicture('https://via.placeholder.com/640x480.png/00ee33?text=rerum')
        ->setRoles(['ROLE_USER'])
        ->setContractType($faker->randomElement($contractTypes))
        ->setDepartment($faker->randomElement($departments));
        
        $manager->persist($regularUser);

        $adminUser = new User();
        $adminUser
        ->setEmail('admin@mycorp.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->hasher->hashPassword($adminUser, 'test'))
        ->setFirstname('Marie')
        ->setLastname('Curie')
        ->setPicture('https://via.placeholder.com/640x480.png/00ee33?text=rerum')
        ->setContractType($faker->randomElement($contractTypes))
        ->setDepartment($faker->randomElement($departments));

        $manager->persist($adminUser);


        $manager->flush();
    }
}
