<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RentalsRepository;

class RentalController extends AbstractController
{
    /**
     * @var RentalsRepository
     */
    private $rentalRepo;

    public function __construct(RentalsRepository $rentalRepository) 
    { 
        $this->rentalRepo = $rentalRepository;
    }

    /**
     * @Route("/rental", name="app_rental")
     */
    public function index(): Response
    {
        $rentals = $this->rentalRepo->findAll();
        dump($rentals);

        return $this->render('rental/rentals.html.twig', [
            'rentals' => $rentals,
        ]);
    }
}
