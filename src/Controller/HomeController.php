<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    #[Route("/", name: "home", methods: ['GET'])]
    public function index(TrickRepository $trickRepository, Request $request): Response {

        $offset = max(0, $request->query->getInt("offset"));
        $tricks = $trickRepository->findTrickPaginated($offset);


        return $this->render('home.html.twig', [
            'offset' => $offset,
            'tricks' => $tricks,
            'previous' => $offset - 15,
            'next' => min(count($tricks), $offset + 15),
            'nbPages' => ceil(count($tricks)) / 15,
        ]);
    }
}