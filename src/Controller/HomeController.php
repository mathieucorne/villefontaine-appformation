<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FormationRepository $formationRepository): Response
    {

        $user = $this->getUser();

        if (!$user){
            return $this->render('home/home.html.twig',[
                'formations'=>[]
            ]);
        }

        if ($user instanceof Utilisateur) {
            $userCompetences = $user->getCompetences()->map(
            fn($uc) => $uc->getCompetence()->getId()
            )->toArray();
        }
        

        $formations = $formationRepository->findUserCompetence($userCompetences);

        return $this->render('home/home.html.twig', [
            'formations' => $formations,
        ]);
    }
}