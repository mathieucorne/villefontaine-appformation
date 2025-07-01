<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\ParametreRepository;


final class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository, ParametreRepository $parametreRepository): Response
    {
        $backgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'background_color'])
            ?->getValeur() ?? '#ffffff';

        $formation = $formationRepository
            ->findAll();

        return $this->render('formation/formation.html.twig', [
            'background_color' => $backgroundColor,
            'formations' => $formation
        ]);
    }
}
