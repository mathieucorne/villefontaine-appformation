<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;
use App\Repository\FormationRepository;

final class FormationsController extends AbstractController
{
    #[Route('/formations', name: 'app_formations')]
    public function index(
        FormationRepository $formationRepository
    ): Response
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $service = $utilisateur->getService();

        $formationsDisponibles = $formationRepository->findFormationsDisponiblesPourService($service);
        $mesFormations = $formationRepository->findMesFormations($utilisateur);

        return $this->render('formations/formations.html.twig', [
            'formationsDisponibles' => $formationsDisponibles,
            'mesFormations' => $mesFormations
        ]);
    }
}
