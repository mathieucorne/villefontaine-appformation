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
    public function index(): Response
    {
        return $this->render('admin_dashboard/admin_dashboard.html.twig', [
        ]);
    }
#[Route('/admin/update-colors', name: 'app_admin_update_colors', methods: ['POST'])]
public function updateColors(
    Request $request,
    ParametreRepository $parametreRepository,
    EntityManagerInterface $entityManager
): Response {
    $colorKeys = ['background_color', 'primary_color', 'utility_button', 'warning_button', 'login_background_color'];

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

    return $this->redirectToRoute('app_admin_dashboard');
    }
}
