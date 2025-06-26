<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\ParametreRepository;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FormationRepository $formationRepository, ParametreRepository $parametreRepository): Response
    {
        $backgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'background_color'])
            ?->getValeur() ?? '#ffffff';

        $formations = $formationRepository->findBy(['estVisible' => true]); //findAll();

        return $this->render('home/home.html.twig', [
            'background_color' => $backgroundColor,
            'formations' => $formations,
        ]);
    }
}