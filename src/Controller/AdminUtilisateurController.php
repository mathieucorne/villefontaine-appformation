<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminUtilisateurController extends AbstractController
{
    #[Route('/admin/utilisateur', name: 'app_admin_utilisateur')]
    public function utilisateurs(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateurs = $utilisateurRepository->findAll();

        return $this-> render('admin_utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

}
