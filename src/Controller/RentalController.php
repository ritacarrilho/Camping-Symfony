<?php

namespace App\Controller;

use App\Entity\Rentals;
use App\Entity\RentalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RentalsRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\RentalTypeForm;
use App\Repository\RentalTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
class RentalController extends AbstractController
{
    /**
     * @var RentalsRepository
     */
    private $rentalRepo;

        /**
     * @var RentalTypeRepository
     */
    private $rentalTypeRepo;

    public function __construct(RentalsRepository $rentalRepository, RentalTypeRepository $rentalTyperRepository) 
    { 
        $this->rentalTypeRepo = $rentalTyperRepository;
        $this->rentalRepo = $rentalRepository;

    }

    /**
     * @Route("/rental", name="app_rental")
     */
    public function rentals(): Response
    {
        $rentals = $this->rentalRepo->findAllInfo();
        // dump($rentals);

        $types = $this->rentalTypeRepo->findAll();
        // dump($types);
        
        return $this->render("rental/rentals.html.twig", [
            "rentals" => $rentals,
            "types" => $types
        ]);
    }

    /**
     * @Route("/rentalType", name="app_filterType", methods={"GET", "POST"})
     * @return Response
     */
    public function listRentalsByType(Request $request)
    {

        $types = $request->get('type');
        $capacities = $request->get('capacity');
        $rentals = $this->rentalRepo->findByType($types, $capacities);
        $labels = $this->rentalTypeRepo->findAll();
        // dump($types);
        // dump($capacities);

        $all_types = $this->rentalTypeRepo->findCategories();

        $types_filtred = [];

        for($i=0; $i < count($all_types); $i++ ) {
            if( $all_types[$i] !== $all_types[$i - 1]->value) {
                array_push($types_filtred, [$i]);
            }
        }
//TODO: filter labels to display only one tu=ime each label
        dump($types_filtred);

        return $this->render("rental/rentalType.html.twig", [
            "rentals" => $rentals,
            "types" => $types,
            'capacities' => $capacities,
            'labels' => $labels
        ]);
    }


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
            $this->addFlash('success', 'You have deleted the rental.');

            return $this->redirectToRoute("app_rental");

        } else {
            return new Response("<h1>Wrong request !</h1>");
        }
    }
}
