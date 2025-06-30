<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ParametreRepository;

final class AdminDashboardController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_admin_dashboard')]
    public function index(ParametreRepository $parametreRepository): Response
    {
        $backgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'background_color'])
            ?->getValeur() ?? '#ffffff';

        $utilityButton= $parametreRepository
            ->findOneBy(['nom' => 'utility_button'])
            ?->getValeur()?? '#4287f5';

        $warningButton = $parametreRepository
            ->findOneBy(['nom' => 'warning_button'])
            ?->getValeur()?? '#fa0202';

        $loginBackgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'login_background_color'])
            ?->getValeur() ?? '#A2BF3B';

        return $this->render('admin_dashboard/admin_dashboard.html.twig', [
            'background_color' => $backgroundColor,
            'utility_button' => $utilityButton,
            'warning_button' => $warningButton, 
            'login_background_color' => $loginBackgroundColor,
        ]);
    }
}
