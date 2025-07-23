<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Session;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SessionsController extends AbstractController
{
    #[Route('/sessions/{id}', name: 'app_session')]
    public function index(
        ParticipationRepository $participationRepository,
        Session $session
    ): Response
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();

        $participations = $participationRepository->findParticipationsUtilisateur($utilisateur);

        $participationsSessionsId = array_map(
            fn($p) => $p->getSession()->getId(),
            $participations
        );

        return $this->render('formations/session.html.twig', [
            'session' => $session,
            'participationsSessionsId' => $participationsSessionsId
        ]);
    }

    #[Route('/sessions/{id}/inscription', name: 'app_session_inscription', methods:['POST'])]
    public function inscrire(
        Session $session,
        Security $security,
        ParticipationRepository $participationRepository,
        Request $request
    ) {
        $utilisateur = $security->getUser();

        $objectifs = $request->request->get('objectifs');
        if($objectifs) {
            $participationRepository->inscrireUtilisateur($utilisateur, $session, $objectifs);
        }

        return $this->redirectToRoute('app_home');
    }

    #[Route('/sessions/{id}/desinscription', name: 'app_session_desinscription')]
    public function desinscrire(
        Session $session,
        Security $security,
        ParticipationRepository $participationRepository
    ) {
        $utilisateur = $security->getUser();
        $participationRepository->desinscrireUtilisateur($utilisateur, $session);

        return $this->redirectToRoute('app_home');
    }
}
