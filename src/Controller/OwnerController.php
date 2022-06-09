<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OwnersRepository;
use App\Repository\RentalsRepository;
use App\Entity\Owners;
use App\Form\OwnerType;

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
        // dump($owners);
        $rentals = $this->rentalsRepo->findOwner();
        // dump($rentals);

        return $this->render('owner/owner.html.twig', [
            'owners' => $owners,
            'rentals' => $rentals
        ]);
    }

    //     /**
    //  * @Route("/addRental/{id}", name="app_addOwner", methods={"GET", "POST"}, requirements = {"id": "\d+"})
    //  */
    // public function addOwner(int $id = -1, Request $request, ManagerRegistry $manager)
    // {
    //     $owner = ($id > 0 ) ? ($this->ownerRepo->find($id)) : new Owners();

    //     $owner_form = $this->createForm(OwnerType::class, $owner);

    //     $owner_form->handleRequest($request);

    //     // dump($owner_form);
        
    //     if ($owner_form->isSubmitted() && $owner_form->isValid()) { // verify if the form was submited by get or post and if the fields where correctly filled
    //         $em = $manager->getManager();
            
    //         $em->persist($owner); // hydrate form data into the object

    //         $em->flush(); // flush data into DB

    //         return $this->redirectToRoute("app_rental"); // redirection towards the rentals list
    //     }

    //     return $this->render('form/editRental.html.twig', [
    //         'form' => $owner_form->createView()
    //     ]);
    // }
}