<?php

namespace App\DataFixtures;
use App\Entity\Brand;
use App\Entity\Material;
use App\Entity\MaterialType;
use App\Entity\Reservation;
use App\Entity\Supplier;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        $tabOwner = [];
        $tabSuppliers= [];
        $tabMaterial= [];
        $tabMaterialType = [];
        $tabBrands = [];




        $faker= Faker\Factory::create('fr_FR');
        $user = new User();
        $user
            ->setPassword(password_hash("test",PASSWORD_DEFAULT))
            ->setEmail("test@gmail.com")
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setTel($faker->phoneNumber)
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user
                ->setPassword($faker->password)
                ->setEmail($faker->email)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setTel($faker->phoneNumber)
                ->setRoles(["ROLE_ADMIN"]);
            $manager->persist($user);
        }

        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $user
                ->setPassword($faker->password)
                ->setEmail($faker->email)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setTel($faker->phoneNumber)
                ->setRoles(["ROLE_OWNER"]);
            $tabOwner [] = $user;

            $manager->persist($user);
        }

        for ($i = 0; $i < 100; $i++) {

            $supplier = new Supplier();
            $supplier
                ->setEmail($faker->email)
                ->setAdress($faker->streetAddress)
                ->setCity($faker->city)
                ->setPhone($faker->phoneNumber)
                ->setPostalCode($faker->randomNumber(5,true))
                ->setName($faker->name)
            ;
            $tabSuppliers [] = $supplier;
            $manager->persist($supplier);
        }

        for ($i = 0; $i < 20; $i++) {

            $materialType = new MaterialType();
            $materialType
                ->setName($faker->word)
            ;
            $tabMaterialType [] = $materialType;
            $manager->persist($materialType);
        }


        for ($i = 0; $i < 10; $i++) {

            $brand = new Brand();
            $brand
                ->setName($faker->word)
            ;
            $tabBrands [] = $brand;
            $manager->persist($brand);
        }


        for ($i = 0; $i < 500; $i++) {

            $material = new Material();
            $material
                ->setUser($tabOwner[rand(0,count($tabOwner)-1)])
                ->setName($faker->word)
                ->setDescription($faker->sentence)
                ->setSupplier($tabSuppliers[rand(0,count($tabSuppliers)-1)])
                ->addMaterialType($tabMaterialType[rand(0,count($tabMaterialType)-1)])
                ->setBrand($tabBrands[rand(0,count($tabBrands)-1)])
                ->setIsAvailable($faker->boolean)
                ->setBudget($faker->word)
                ->setBCnumber($faker->randomNumber(8,true))
                ->setDeleveryDate($faker->dateTime)
                ->setEndOfGuarantyDate($faker->dateTime)
                ->setInventoryNumber($faker->randomNumber(8,true))
            ;
            $tabMaterial [] = $material;
            $manager->persist($material);
        }




        for ($i = 0; $i < 500; $i++) {

            $reservation = new Reservation();
            $reservation
                ->setMaterial($tabMaterial[rand(0,count($tabMaterial)-1)])
                ->setEmailBorrower($faker->email)
                ->setStartDate($faker->dateTime)
                ->setEndDate($faker->dateTime)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setStatutBorrower($faker->randomElement(['Perma','doc','postdoc','etudiant','ext']))
            ;
            $manager->persist($reservation);
        }
dd("Enlever les emails lors des fixtures");
//TODO ENLEVER EMAIL QUAND ON LANCE FIXTURES
//        $manager->flush();
    }


}
