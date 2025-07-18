<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;
use App\Repository\FormationRepository;
use App\Repository\ParticipationRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        FormationRepository $formationRepository,
        ParticipationRepository $participationRepository
    ): Response
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $service = $utilisateur->getService();

        $formationsDisponibles = $formationRepository->findFormationsDisponiblesPourService($service, $utilisateur);
        $participations = $participationRepository->findParticipationsUtilisateur($utilisateur);

        $participationsSessionsId = array_map(
            fn($p) => $p->getSession()->getId(),
            $participations
        );

        return $this->render('home/home.html.twig', [
            'formationsDisponibles' => $formationsDisponibles,
            'participationsSessionsId' => $participationsSessionsId
        ]);
    }
}