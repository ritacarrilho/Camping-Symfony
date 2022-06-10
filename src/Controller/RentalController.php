<?php

namespace App\Controller;

use App\Entity\Rentals;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RentalsRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\RentalTypeForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function rentals(): Response
    {
        $rentals = $this->rentalRepo->findAllInfo();

        return $this->render('rental/rentals.html.twig', [
            'rentals' => $rentals,
        ]);
    }

    // /**
    //  * @Route("/rentalType/{type}", name="app_filterType", methods={"GET"})
    //  * @return Response
    //  */
    // public function listByType($type): Response
    // {
    //     $rentals = $this->rentalRepo->findByType($type);

    //     return $this->render('rental/rentalType.html.twig', [
    //         'rentals' => $rentals,
    //     ]);
    // }


    /**
     * @Route("/addRental/{id}", name="app_addRental", methods={"GET", "POST"}, requirements = {"id": "\d+"})
     */
    public function addRental(int $id = -1, Request $request, ManagerRegistry $manager)
    {
        $rental = ($id > 0 ) ? ($this->rentalRepo->find($id)) : new Rentals();

        $rental_form = $this->createForm(RentalTypeForm::class, $rental);

        $rental_form->handleRequest($request);

        if ($rental_form->isSubmitted() && $rental_form->isValid()) { // verify if the form was submited by get or post and if the fields where correctly filled
            $em = $manager->getManager();
            
            $em->persist($rental); // hydrate form data into the object

            $em->flush(); // flush data into DB

            $this->addFlash('success', 'You have added a new rental.');
            return $this->redirectToRoute("app_rental"); // redirection towards the rentals list
        }

        return $this->render('form/editRental.html.twig', [
            'form' => $rental_form->createView(), 
        ]);
    }

    /**
     * @Route("/deleteRental/{id}", name="app_deleteRental", methods={"POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @return void
     */
    public function deleteRental(int $id = -1, Request $request, ManagerRegistry $managerRegistry) // method get recovers the form click and the method post recovers the form submition | id = -1 in case there is no id passed
    { 
        // verify if token is valid
        if($this->isCsrfTokenValid('delete'.$id, $request->get('_token'))) {
            $em = $managerRegistry->getManager();

            $rental = $this->rentalRepo->find($id);

            $em->remove($rental);
            $em->flush();
            $this->addFlash('success', 'You have deleted the author.');

            return $this->redirectToRoute("app_rental");

        } else {
            return new Response("<h1>Wrong request !</h1>");
        }
    }
}
