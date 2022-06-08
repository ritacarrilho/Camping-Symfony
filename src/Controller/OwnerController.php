<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OwnersRepository;

class OwnerController extends AbstractController
{
    /**
     * @var OwnersRepository
     */
    private $ownersRepo;

    public function __construct(OwnersRepository $ownersRepository)
    { 
        $this->ownersRepo = $ownersRepository;
    }

    /**
     * @Route("/partners", name="app_owner")
     */
    public function ownersList(): Response
    {
        $owners = $this->ownersRepo->findAll();

        return $this->render('owner/owner.html.twig', [
            'owners' => $owners,
        ]);
    }
}
