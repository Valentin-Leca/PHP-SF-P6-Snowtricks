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

    /**
     * @throws Exception
     */
    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): void {
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

        $userMail = $request->request->get("mail");

        $user = $entityManager->getRepository(User::class)->findOneBy(['mail' => $userMail]);

        if ($user) {

            $user->setToken(bin2hex(random_bytes(32)));
            $forgotPasswordMail->sendForgotPasswordMail($user);
            $entityManager->flush();

            $this->addFlash(type: "success", message: "Demande de réinitialisation de mot de passe envoyée !");
        }

        return $this->render('login/changePassword.html.twig');
    }

    #[Route('/resetPassword/{login}/{token}', name: 'resetPassword', methods: ['GET', 'POST'])]
    public function resetPassword(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface
    $entityManager, User $user): Response {

        if ($request->isMethod('POST')) {

            $firstPassword = $request->request->get("password");
            $secondPassword = $request->request->get("secondPassword");

            if ($firstPassword === $secondPassword) {
                $user->setToken(null);
                $user->setPassword($hasher->hashPassword($user, $firstPassword));
                $entityManager->flush();
                $this->addFlash(type: "success", message: "Votre mot de passe a bien été modifié !");
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash(type: "error", message: "Vos deux mots de passes ne sont pas identiques !");
                return $this->redirectToRoute('resetPassword', ['login' => $user->getLogin(),
                    'token' => $user->getToken()
                ]);
            }
        }

        return $this->render("login/resetPassword.html.twig", [
            'user' => $user,
        ]);
    }
}
