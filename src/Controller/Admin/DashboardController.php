<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AnnonceCrudController;
use App\Entity\Annonce;
use App\Entity\Category;
use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
            $url = $this->adminUrlGenerator
            ->setController(AnnonceCrudController::class)
            ->generateUrl();
    
            return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon Blog');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Accueil', 'fa fa-home', '/');

        yield MenuItem::subMenu('Articles', 'fas fa-bell-concierge')->setSubItems([
            MenuItem::linkToCrud('Créer un article', 'fas fa-bell-concierge', Annonce::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Aperçu des articles', 'fas fa-eye', Annonce::class)
        ]);

        yield MenuItem::subMenu('Commentaire', 'fas fa-comments')->setSubItems([
            MenuItem::linkToCrud('Créer un nouveau commentaire', 'fas fa-comments', Comment::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Aperçue des commentaires', 'fas fa-eye', Comment::class)
        ]);

        yield MenuItem::subMenu('Sujet', 'fas fa-comments')->setSubItems([
            MenuItem::linkToCrud('Créer un nouveau sujet', 'fas fa-comments', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Aperçue des sujets', 'fas fa-eye', category::class)
        ]);
    }
}
