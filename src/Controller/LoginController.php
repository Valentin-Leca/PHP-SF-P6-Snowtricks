<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController {

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response {

        return $this->render('login/index.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(), // last username entered by the user
            'error' => $authenticationUtils->getLastAuthenticationError(), // get the login error if there is one
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout() {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
