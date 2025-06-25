<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findAll(); // ou un findBy(['estVisible' => true])

        return $this->render('home/index.html.twig', [
            'formations' => $formations,
        ]);
    }
}
