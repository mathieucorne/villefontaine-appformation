<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomComplet')->hideOnForm(),
            TextField::new('prenom')->hideOnIndex(),
            TextField::new('nom')->hideOnIndex(),
            TextField::new('email'),
            ChoiceField::new('roles')
                ->setChoices(
                    [
                        'Utilisateur' => 'ROLE_USER',
                        'Gestionnaire de formations' => 'ROLE_RH',
                        'Administrateur' => 'ROLE_ADMIN'
                    ]
                )->allowMultipleChoices(),
        ];

        if ($pageName === Crud::PAGE_NEW) {
            array_push(
                $fields, 
                TextField::new('plainPassword', 'Nouveau mot de passe')
                ->setFormType(PasswordType::class)
                ->hideOnIndex()
                ->setRequired(false)
            );
        }

        if ($pageName === Crud::PAGE_EDIT) {
            array_push(
                $fields, 
                TextField::new('plainPassword', 'Nouveau mot de passe')
                ->setFormType(PasswordType::class)
                ->hideOnIndex()
                ->setRequired(false)
                ->setHelp('Modifier pour changer le mot de passe')
            );
        }

        return $fields;
    }
}
