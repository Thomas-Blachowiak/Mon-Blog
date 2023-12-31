<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield    TextField::new('lastName', 'Nom');
        yield    TextareaField::new('content', 'Contenue');
        yield    BooleanField::new('approved', 'Approuvé')
                    ->renderAsSwitch();
        yield    BooleanField::new('rgpd', 'rgpd')
                    ->renderAsSwitch();
        yield TextField::new('annonce', 'Annonce');
    }

}
