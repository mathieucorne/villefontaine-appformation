<?php

namespace App\Controller\Admin;

use App\Entity\Participation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ParticipationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Participation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('objectifs'),
            AssociationField::new('utilisateur'),
            AssociationField::new('session'),
            DateTimeField::new('dateInscription'),
            BooleanField::new('estPresent'),
        ];
    }
}
