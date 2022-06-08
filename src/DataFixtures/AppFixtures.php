<?php

namespace App\DataFixtures;

use App\Entity\Owners;
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

        $manager->flush();
    }

// SERVICES
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

// PARTNERS/OWNERS
    public function loadPartners($manager, $faker)
    {
        $partners_number = 10;

        for($i=0; $i < $partners_number; $i++) {
            $partner = new Owners();
            $partner->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setAddress($faker->address)
                    ->setContractNumber(rand())
                    ->setEndDate($faker->dateTimeBetween('now', '+5 years'));
        
            $this->addReference('partner-' . $i, $partner);

            $manager->persist($partner);
        }
    
// USERS - relation one to one
        for($j=0; $j < $partners_number; $j++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setRole("ROLE_USER")
                ->setPassword($this->pass_hasher->hashPassword($user, $faker->password))
                ->setOwnerId($this->getReference(('partner-'. $j)));
                
                $manager->persist( $user);  
        }   
    } 
}
