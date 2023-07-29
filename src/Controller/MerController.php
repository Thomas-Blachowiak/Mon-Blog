<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\ItemInterface;


class MerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/mer', name: 'mer')]
    public function index(AnnonceRepository $annonceRepository, CategoryRepository $categoryRepository, CommentRepository $commentRepository, Request $request): Response
    {

        $comment = new Comment();
        $comment->setApproved(false);

        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            
    // Ajouter un message flash
    $this->addFlash('success', 'Le commentaire a été envoyé avec succès.');

            return $this->redirectToRoute('mer');

        }
        
        return $this->render('mer/mer.html.twig', [
            'controller_name' => 'MerController',
            'annonce' => $annonceRepository->findBy([], []),
            'category' => $categoryRepository->findBy([], []),
            'commentForm' => $commentForm->createView(),
            'comment' => $commentRepository->findBy([], []),
        ]);
    }
    #[Route('/mer/comment/approved', name: 'mer_approved')]
    public function approveTestimonial(comment $comment): Response
    {
        $comment->setApproved(true);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }

    #[Route('/mer/comment/disapprove', name: 'mer_disapproved')]
    public function disapproveTestimonial(comment $comment): Response
    {
        $comment->setApproved(false);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }
}
