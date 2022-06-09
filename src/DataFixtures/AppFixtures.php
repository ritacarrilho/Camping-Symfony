<?php

namespace App\DataFixtures;

use App\Entity\Owners;
use App\Entity\Rentals;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\RentalType;
use App\Entity\User;
use App\Entity\Services;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
     /**
     * @var
     */
    private $pass_hasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->pass_hasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('en_EN'); // call package Faker, object Factory

        $this->loadServices($manager);
        $this->loadPartners($manager, $faker);
        $this->loadRentals($manager, $faker);

        $manager->flush();
    }

// --------------------- SERVICES
    public function loadServices($manager)
    {
        $rental_type = [
            ['Caravan', 2, 15],
            ['Caravan', 4, 18],
            ['Caravan', 6, 24],
            ['Mobile-Home', 2, 20],
            ['Mobile-Home', 4, 24],
            ['Mobile-Home', 5, 27],
            ['Mobile-Home', 6, 34],
            ['space', 8, 12],
            ['space', 12, 14],
        ];

        $services = [
            ['Pool Tax', 100, 'Kids'],
            ['Pool Tax', 150, 'Adults'],
            ['Daily Tax', 35, 'Kids'],
            ['Daily Tax', 60, 'Adults']
        ];

        // RENTALTYPE
        for($i=0; $i < count($rental_type); $i++) {
            $rental = new RentalType();
            $rental->setLabel($rental_type[$i][0])
                    ->setCapacity($rental_type[$i][1])
                    ->setdailyPrice($rental_type[$i][2]);

            $manager->persist($rental); // generate an object, keep it in memory in a generic array
        
            $this->addReference('rental-' . $i, $rental);

        }

        // SERVICES
        for($i=0; $i < count($services); $i++) {
            $service = new Services();
            $service->setLabel($services[$i][0])
                    ->setPerDay(($services[$i][1]))
                    ->setConsumerType($services[$i][2]);

            $manager->persist($service);
        }
    }

// ----------------- PARTNERS/OWNERS
    public function loadPartners($manager, $faker)
    {
        $admin_owner = new Owners();

        $admin_owner->setFirstName('Fabulous')
                    ->setLastName('Camping')
                    ->setAddress($faker->address)
                    ->setContractNumber(0)
                    ->setEndDate($faker->dateTimeBetween('now', '+80 years'));

        $this->addReference('partner-' . 1, $admin_owner);

        $manager->persist($admin_owner);

        $partners_number = 10;

        for($i=1; $i <= $partners_number; $i++) {
            $partner = new Owners();
            $partner->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setAddress($faker->address)
                    ->setContractNumber(rand())
                    ->setEndDate($faker->dateTimeBetween('now', '+5 years'));
        
            $this->addReference('partner-' . ($i+1), $partner);

            $manager->persist($partner);
        }
    
// USERS - relation one to one
        $admin_user = new User();

        $admin_user->setEmail('fabulous_camping@gmail.com')
        ->setRole("ROLE_ADMIN")
        ->setPassword($this->pass_hasher->hashPassword($admin_user, 'admin'))
        ->setOwnerId($this->getReference('partner-'. 1));
        
        $manager->persist( $admin_user);  


        for($j=1; $j <= $partners_number; $j++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setRole("ROLE_USER")
                ->setPassword($this->pass_hasher->hashPassword($user, $faker->password))
                ->setOwnerId($this->getReference(('partner-'. ($j+1) )));
                
                $manager->persist( $user);  
        }   
    } 

// ------------ RENTALS
    public function loadRentals($manager, $faker)
    {
        $emplacements_nb = 30;
        $private_mh = 30;
        $camping_mh = 20;
        $caravans = 10;

// EMPLACEMENTS        
        for($i=0; $i < $emplacements_nb; $i++) {
            $emplacements = new Rentals();

            $emplacements->setOwnerId($this->getReference('partner-' . 1))
                    ->setTypeId($this->getReference(('rental-'. rand(7, 8))))
                    ->setTitle('Space '. $faker->word )
                    ->setDescription($faker->sentence)
                    ->setReference(rand(1, 30))
                    ->setPicture('tent.png');

            $manager->persist($emplacements);
        }

//MOBILE HOMES CAMPING
        for($j=0; $j < $camping_mh; $j++) {
            $mh_camping = new Rentals();

            $mh_camping->setOwnerId($this->getReference('partner-' . 1))
                    ->setTypeId($this->getReference(('rental-'. rand(3, 6) )))
                    ->setTitle('Mobile-Home '. $faker->word )
                    ->setDescription($faker->sentence)
                    ->setReference(rand(31, 60))
                    ->setPicture('mobile.jpg');

            $manager->persist($mh_camping);
        }

//PRIVATE MOBILE HOMES
        for($l=0; $l < $private_mh; $l++) {
            $mh_private = new Rentals();

            $mh_private->setOwnerId($this->getReference('partner-' . rand(2, 11)))
                    ->setTypeId($this->getReference(('rental-'. rand(3, 6) )))
                    ->setTitle('Mobile-Home '. $faker->word )
                    ->setDescription($faker->sentence)
                    ->setReference(rand(31, 60))
                    ->setPicture('mobile.jpg');

            $manager->persist($mh_private);
        }

//CARAVANS
        for($h=0; $h < $caravans; $h++) {
            $caravans_camping = new Rentals();

            $caravans_camping->setOwnerId($this->getReference('partner-' . 1))
                ->setTypeId($this->getReference(('rental-'. rand(0, 2) )))
                ->setTitle('Caravan '. $faker->word )
                ->setDescription($faker->sentence)
                ->setReference(rand(61, 200))
                ->setPicture('caravan.jpg');

            $manager->persist($caravans_camping);
        }
     }
}
