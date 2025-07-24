<?php

namespace App\Controller\Admin;

use App\Entity\Visibilite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class VisibiliteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visibilite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('session'),
            AssociationField::new('service'),
        ];
    }
}
