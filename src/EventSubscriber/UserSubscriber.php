<?php

namespace App\EventSubscriber;

use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Event\AbstractLifecycleEvent;

class UserSubscriber implements EventSubscriberInterface 
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public static function getSubscribedEvents() : array
    {
        return [
            BeforeEntityPersistedEvent::class => ['encodePassword'],
            BeforeEntityUpdatedEvent::class => ['encodePassword'],
        ];
    }

    public function encodePassword(AbstractLifecycleEvent $event): void
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $event->getEntityInstance();

        if ($utilisateur->getPlainPassword() && $this->passwordHasher->isPasswordValid($utilisateur, $utilisateur->getPlainPassword())) {
            $hashed = $this->passwordHasher->hashPassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($hashed);
            $utilisateur->setPlainPassword(null);
        }
    }
}