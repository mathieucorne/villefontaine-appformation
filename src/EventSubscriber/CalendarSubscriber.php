<?php

namespace App\EventSubscriber;

use App\Repository\SessionRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\SetDataEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private SessionRepository $sessionRepository;
    private Security $security;
    private RouterInterface $router;

    public function __construct(
        SessionRepository $sessionRepository, 
        Security $security,
        RouterInterface $router
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->security = $security;
        $this->router = $router;
    }

    public static function getSubscribedEvents() : array
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
            $url = $this->router->generate('app_session', [
                'id' => $session->getId()
            ]);
            $setDataEvent->addEvent(new Event(
                $session->getTitreComplet(),
                $session->getHeureDebut(),
                $session->getHeureFin(),
                null,
                [
                    'url' => $url
                ]

            ));
        }
    }
}