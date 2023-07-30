<?php

namespace App\Controller\Admin;

use App\Entity\Annonce;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnnonceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Annonce::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield    TextField::new('name', 'Nom');
        yield    TextareaField::new('content', 'Contenue');
        yield    ImageField::new('photo')
        ->setBasePath('uploads/images')
        ->setUploadDir('public/uploads/images')
        ->setSortable(false);
        yield AssociationField::new('category', 'Catégorie')
        ->setLabel('name');    
    }
}
