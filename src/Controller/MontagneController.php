<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MontagneController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/montagne', name: 'montagne')]
    public function index(AnnonceRepository $annonceRepository, CategoryRepository $categoryRepository, CommentRepository $commentRepository, Request $request): Response
    {
        $comment = new Comment();
        $comment->setApproved(false);

        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('montagne');

        }
        
        return $this->render('montagne/montagne.html.twig', [
            'controller_name' => 'MontagneController',
            'annonce' => $annonceRepository->findBy([], []),
            'category' => $categoryRepository->findBy([], []),
            'commentForm' => $commentForm->createView(),
            'comment' => $commentRepository->findBy([], []),
        ]);
    }



    #[Route('/admin/comment/approve/{id}', name: 'admin_comment_approve')]
    public function approveTestimonial(comment $comment): Response
    {
        $comment->setApproved(true);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }

    #[Route('/admin/comment/disapprove/{id}', name: 'admin_comment_disapprove')]
    public function disapproveTestimonial(comment $comment): Response
    {
        $comment->setApproved(false);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }
}
