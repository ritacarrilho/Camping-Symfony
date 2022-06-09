<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OwnersRepository;
use App\Repository\RentalsRepository;

class OwnerController extends AbstractController
{
    /**
     * @var OwnersRepository
     */
    private $ownersRepo;

    /**
     * @var RentalsRepository
     */
    private $rentalsRepo;

    public function __construct(OwnersRepository $ownersRepository, RentalsRepository $rentalsRepository)
    { 
        $this->ownersRepo = $ownersRepository;
        $this->rentalsRepo = $rentalsRepository;
    }

    /**
     * @Route("/partners", name="app_owner")
     */
    public function ownersList(): Response
    {
        $owners = $this->ownersRepo->findAll();
        dump($owners);
        $rentals = $this->rentalsRepo->findOwner();
        dump($rentals);

        return $this->render('owner/owner.html.twig', [
            'owners' => $owners,
            'rentals' => $rentals
        ]);
    }
}
