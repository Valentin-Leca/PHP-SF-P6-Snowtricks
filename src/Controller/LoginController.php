<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController {

    #[Route('/login', name: 'login', methods: ["POST", "GET"])]
    public function login(EntityManagerInterface $entityManager): Response {

        $user = new User();

        $form = $this->createForm(LoginType::class, $user);

        return $this->render('login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
