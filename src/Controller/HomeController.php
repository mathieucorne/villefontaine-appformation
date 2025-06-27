<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\ParametreRepository;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FormationRepository $formationRepository, ParametreRepository $parametreRepository): Response
    {

        $user = $this->getUser();

        if (!$user){
            return $this->render('home/home.html.twig',[
                'formations'=>[]
            ]);
        }

        $userCompetences = $user->getCompetences()->map(
            fn($uc) => $uc->getCompetence()->getId()
        )->toArray();

        $backgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'background_color'])
            ?->getValeur() ?? '#ffffff';

        $formations = $formationRepository->findUserCompetence($userCompetences);

        return $this->render('home/home.html.twig', [
            'background_color' => $backgroundColor,
            'formations' => $formations,
        ]);
    }
}