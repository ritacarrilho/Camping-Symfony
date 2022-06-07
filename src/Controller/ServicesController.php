<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RentalTypeRepository;
use App\Repository\ServicesRepository;

class ServicesController extends AbstractController
{
    /**
     * @var RentalTypeRepository
     */
    private $rentalTypeRepo;

    /**
     * @var ServicesRepository
     */
    private $servicesRepo;

    public function __construct(RentalTypeRepository $rentalTypeRepository, ServicesRepository $servicesRepository) // injection, allows to have access to repository all over the file
    { 
        $this->rentalTypeRepo = $rentalTypeRepository;
        $this->servicesRepo = $servicesRepository;

    }

    /**
     * @Route("/services", name="app_services")
     */
    public function servicesList() 
    {
        $services = $this->rentalTypeRepo->findAll();
        $taxes = $this->servicesRepo->findAll();

        return $this->render('services/services.html.twig', [
            'services' => $services,
            'taxes' => $taxes
        ]);
    }

}
