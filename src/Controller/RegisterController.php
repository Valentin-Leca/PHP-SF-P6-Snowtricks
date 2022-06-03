<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Service\RegisterMail;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @throws Exception|TransportExceptionInterface
     */
    #[Route('/register', name: 'register', methods: ["POST", "GET"])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher,
        RegisterMail $registerMail
    ): Response {

        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_USER"]);
            $user->setToken(bin2hex(random_bytes(32)));

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(type: "success", message: "Inscription réussie ! Veuillez valider votre compte via le mail d'inscription.");

            $registerMail->sendRegisterMail($user);

        }

        return $this->render('register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/verify/{login}/{token}', name: 'verify', methods: ["POST", "GET"])]
    public function verify(User $user, EntityManagerInterface $entityManager): Response {

        $user->setIsValid(true);
        $user->setToken(null);
        $entityManager->flush();

        return $this->render('accountIsValid.html.twig');
    }
}
