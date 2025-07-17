<?php

namespace App\EventSubscriber;

use App\Repository\SessionRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\SetDataEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private SessionRepository $sessionRepository;
    private Security $security;

    public function __construct(SessionRepository $sessionRepository, Security $security)
    {
        $this->sessionRepository = $sessionRepository;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            SetDataEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(SetDataEvent $setDataEvent)
    {
        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();
        $filters = $setDataEvent->getFilters();
        $utilisateur = $this->security->getUser();

        $sessions = $this->sessionRepository->findMesSessions($utilisateur);

        foreach ($sessions as $session) {
            $setDataEvent->addEvent(new Event(
                $session->getTitre(),
                $session->getHeureDebut(),
                $session->getHeureFin()
            ));
        }
    }
}