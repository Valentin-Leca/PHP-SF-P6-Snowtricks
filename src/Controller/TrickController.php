<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\UploadFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/trick')]
class TrickController extends AbstractController {

    #[Route('/', name: 'app_trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response {

        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UploadFile $uploadFile, TrickRepository $trickRepository): Response {

        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($form->getData()->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUser($this->getUser());

//            if ($uploadFile->uploadVideo($trick) === false) {
//                $this->addFlash("error", "Veuillez ajouter un lien de vidéo qui provient bien de Youtube.");
//                return $this->redirectToRoute('app_trick_new', [], Response::HTTP_SEE_OTHER);
//            } elseif ($uploadFile->uploadImage($trick) === false) {
//                $this->addFlash("error", "Veuillez renseigner tous les champs images.");
//                return $this->redirectToRoute('app_trick_new', [], Response::HTTP_SEE_OTHER);
//            } else {
                $uploadFile->uploadImage($trick);
                $uploadFile->uploadVideo($trick);
                $trickRepository->add($trick, true);

                return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
//            }
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Trick $trick, CommentRepository $commentRepository): Response {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);
            $commentRepository->add($comment, true);

            return $this->redirectToRoute('app_trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UploadFile $uploadFile, Trick $trick, TrickRepository $trickRepository): Response {

        $this->denyAccessUnlessGranted('POST_VIEW', $this->getUser());
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($form->getData()->getName());
            $trick->setSlug(strtolower($slug));
            $trick->setUpdatedAt(date_create_immutable());

            if ($uploadFile->uploadVideo($trick) === false) {
                $this->addFlash("error", "Veuillez ajouter un lien de vidéo qui provient bien de Youtube.");
                return $this->redirectToRoute('app_trick_edit', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
            } elseif ($uploadFile->uploadImage($trick) === false) {
                $this->addFlash("error", "Veuillez renseigner tous les champs images que vous ajoutez.");
                return $this->redirectToRoute('app_trick_edit', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
            } else {
                $uploadFile->uploadImage($trick);
                $uploadFile->uploadVideo($trick);
                $trickRepository->add($trick, true);

                return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response {

        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }

        return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
    }
}

// TODO Vérifier la limite images et vidéos à 3

// TODO data-fixtures pour les figures + 1 utilisateur

// TODO voir pourquoi bouton poubelle ne fonctionne pas

// TODO pagination https://nicolasfz-code.medium.com/symfony-paginer-les-r%C3%A9sultats-dune-requ%C3%AAte-avec-doctrine-ebe7873197c9
// TODO https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/tutorials/pagination.html

// TODO ajouter remove d'image dans vidéo (ligne 43) service UploadFile.php
