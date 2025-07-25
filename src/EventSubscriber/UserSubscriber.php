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
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Utilisateur) {
            return;
        }
        
        if ($entity->getPlainPassword() && $this->passwordHasher->isPasswordValid($entity, $entity->getPlainPassword())) {
            $hashed = $this->passwordHasher->hashPassword($entity, $entity->getPlainPassword());
            $entity->setPassword($hashed);
            $entity->eraseCredentials();
        }
    }
}