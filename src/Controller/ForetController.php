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

class ForetController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/foret', name: 'foret')]
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
        
        return $this->render('foret/index.html.twig', [
            'controller_name' => 'ForetController',
            'annonce' => $annonceRepository->findBy([], []),
            'category' => $categoryRepository->findBy([], []),
            'commentForm' => $commentForm->createView(),
            'comment' => $commentRepository->findBy([], []),
        ]);
    }
    #[Route('foret/comment/approved', name: 'foret_approved')]
    public function approveTestimonial(comment $comment): Response
    {
        $comment->setApproved(true);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }

    #[Route('/foret/comment/disapprove', name: 'foret_disapproved')]
    public function disapproveTestimonial(comment $comment): Response
    {
        $comment->setApproved(false);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }
}
