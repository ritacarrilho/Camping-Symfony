<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnerController extends AbstractController
{
    /**
     * @Route("/owner", name="app_owner")
     */
    public function index(): Response
    {
        return $this->render('owner/index.html.twig', [
            'controller_name' => 'OwnerController',
        ]);
    }
}
