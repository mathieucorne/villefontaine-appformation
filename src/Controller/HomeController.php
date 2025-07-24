<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;
use App\Repository\FormationRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        FormationRepository $formationRepository,
    ): Response
    {
        $formationsDisponibles = $formationRepository->findFormationsVisibles();
        $maintenant = new \DateTime();

        return $this->render('home/home.html.twig', [
            'formationsDisponibles' => $formationsDisponibles,
            'maintenant' => $maintenant
        ]);
    }
}