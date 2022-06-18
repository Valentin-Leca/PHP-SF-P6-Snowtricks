<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ForgotPasswordMail;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    #[Route('/forgetPassword', name: 'forgetPassword', methods: ['GET', 'POST'])]
    public function forgetPassword(
        Request $request,
        EntityManagerInterface $entityManager,
        ForgotPasswordMail $forgotPasswordMail): Response {

        $request = Request::createFromGlobals();

        $userMail = $request->request->get("mail");

        $userRepository = $entityManager->getRepository(User::class);

        $user = $userRepository->findOneBy(['mail' => $userMail]);

        if ($user) {

            $user->setToken(bin2hex(random_bytes(32)));
            $forgotPasswordMail->sendForgotPasswordMail($user);
            $entityManager->flush();

            $this->addFlash(type: "success", message: "Demande de réinitialisation de mot de passe envoyé !");
        } elseif($user != true) {
            $this->addFlash(type: "error", message: "Cette adresse e-mail n'est associé à aucun compte utilisateur !");
        }

        return $this->render('login/changePassword.html.twig');
    }

    #[Route('/resetPassword/{token}', name: 'resetPassword', methods: ['GET', 'POST'])]
    public function resetPassword(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager) {

        $request = Request::createFromGlobals();

        $userLogin = $request->request->get("login");

        $userRepository = $entityManager->getRepository(User::class);

        $user = $userRepository->findOneBy(['login' => $userLogin]);
        $firstPassword = $request->request->get("password");
        $secondPassword = $request->request->get("secondPassword");


        if ($user && $firstPassword === $secondPassword) {
            $user->setToken(null);
            $user->setPassword($hasher->hashPassword($user, $firstPassword));
            $entityManager->flush();
            $this->redirectToRoute('login');
            $this->addFlash(type: "error", message: "Bravo !");
        } else {
            $this->addFlash(type: "error", message: "Ce login n'est associé à aucun compte utilisateur !");
        }

        return $this->render("login/resetPassword.html.twig");
    }
}
