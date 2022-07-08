<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickControllerAU_CAS_OU extends AbstractController {

    #[Route("/trick", name: "trick", methods: ['GET'])]
    public function index(): Response {

        return $this->render('trick.html.twig', [
            'controller_name' => 'TrickControllerAUCASOU',
        ]);
    }
}