<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\RentalType;
use App\Entity\Services;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('en_EN'); // call package Faker, object Factory

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

        $manager->flush();
    }
}
