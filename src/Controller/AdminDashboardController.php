<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParametreRepository;
use App\Entity\Parametre;


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
            ?->getValeur() ?? '#4287f5';

        $warningButton = $parametreRepository
            ->findOneBy(['nom' => 'warning_button'])
            ?->getValeur() ?? '#fa0202';

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
#[Route('/admin/update-colors', name: 'admin_update_colors', methods: ['POST'])]
public function updateColors(
    Request $request,
    ParametreRepository $parametreRepository,
    EntityManagerInterface $entityManager
): Response {
    $colorKeys = ['background_color', 'utility_button', 'warning_button', 'login_background_color'];

    foreach ($colorKeys as $key) {
        $value = $request->request->get($key);
        if (!$value || !preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
            continue; // Ignore ou log une erreur si tu veux
        }

        $param = $parametreRepository->findOneBy(['nom' => $key]);

        if (!$param) {
            $param = new Parametre();
            $param->setNom($key);
        }

        $param->setValeur($value);
        $entityManager->persist($param);
    }

    $entityManager->flush();

    $this->addFlash('success', 'Les couleurs ont été mises à jour.');

    return $this->redirectToRoute('app_admin_dashboard');
    }
}
