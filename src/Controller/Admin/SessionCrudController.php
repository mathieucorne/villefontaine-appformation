<?php

namespace App\Controller\Admin;

use App\EasyAdmin\Field\ServiceSelectorField;
use App\Entity\Session;
use App\Entity\SessionService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            DateTimeField::new('heure_debut'),
            DateTimeField::new('heure_fin'),
            DateTimeField::new('dateLimiteInscription'),
            AssociationField::new('formation'),
            AssociationField::new('salle'),
            IntegerField::new('nb_participants_max'),
        ];
    }

    // public function persistEntity(EntityManagerInterface $em, $entityInstance): void {
    //     if(!$entityInstance instanceof Session) return;

    //     $this->syncServices($entityInstance, $em);

    //     parent::persistEntity($em, $entityInstance);
    // }

    // public function updateEntity(EntityManagerInterface $em, $entityInstance): void {
    //     if($entityInstance instanceof Session) return;

    //     $this->syncServices($entityInstance, $em);

    //     parent::updateEntity($em, $entityInstance);

    // }

    // public function syncServices(Session $session, EntityManagerInterface $em): void {
    //     foreach($session->getSessionServices() as $sessionService) {
    //         $em->remove($sessionService);
    //     }

    //     $session->getSessionServices()->clear();

    //     foreach($session->getServices() as $service) {
    //         $sessionService = new SessionService();
    //         $sessionService->setSession($session);
    //         $sessionService->setService($service);

    //         $em->persist($sessionService);
    //         $session->getSessionServices()->add($sessionService);
    //     }
    // }
}
