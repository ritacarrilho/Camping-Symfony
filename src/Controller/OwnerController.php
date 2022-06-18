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
use App\Form\PartnerType;

/**
 * @Route("/admin")
 */
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

    /**
     * @Route("/addOwner/{id}", name="app_addOwner", methods={"GET", "POST"}, requirements = {"id": "\d+"})
     */
    public function addOwner(int $id = -1, Request $request, ManagerRegistry $manager)
    {
        $owner = ($id > 0 ) ? ($this->ownersRepo->find($id)) : new Owners();

        $owner_form = $this->createForm(PartnerType::class, $owner);

        $owner_form->handleRequest($request);

        if ($owner_form->isSubmitted() && $owner_form->isValid()) { // verify if the form was submited by get or post and if the fields where correctly filled
            $em = $manager->getManager();
            
            $em->persist($owner); // hydrate form data into the object

            $em->flush(); // flush data into DB

            $this->addFlash('success', 'You have added a new partner.');
            return $this->redirectToRoute("app_owner"); // redirection towards the rentals list
        }

        return $this->render('form/addOwner.html.twig', [
            'form' => $owner_form->createView(), 
        ]);
    }

    /**
     * @Route("/deleteOwner/{id}", name="app_deleteOwner", methods={"POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @return void
     */
    public function deleteRental(int $id = -1, Request $request, ManagerRegistry $managerRegistry) // method get recovers the form click and the method post recovers the form submition | id = -1 in case there is no id passed
    { 
        // verify if token is valid
        if($this->isCsrfTokenValid('delete'.$id, $request->get('_token'))) {
            $em = $managerRegistry->getManager();

            $owner = $this->ownersRepo->find($id);

            $em->remove($owner);
            $em->flush();
            $this->addFlash('success', 'You have deleted the partner.');

            return $this->redirectToRoute("app_owner");

        } else {
            return new Response("<h1>Wrong request !</h1>");
        }
    }
}