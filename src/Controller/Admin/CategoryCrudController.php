<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield    TextField::new('name', 'Nom');
        yield    TextareaField::new('content', 'Contenue');
        yield    TextareaField::new('quand', 'Quand ?');
        yield    TextField::new('ou', 'Localisation');
        yield    TextareaField::new('pourquoi', 'Pourquoi ?');

    }
}
