<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Handler\UserFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController {

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserFormHandler $userFormHandler): Response {

        $this->denyAccessUnlessGranted('POST_VIEW', $user);

        $form = $this->createForm(UserType::class, null, ['avatar' => $user->getAvatar()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userFormHandler->setAndFlushUserForm($user, $form);

            $this->addFlash("success", "Votre profil a bien été mis à jour !");

            return $this->redirectToRoute('app_user_edit', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
