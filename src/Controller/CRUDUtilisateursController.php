<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CRUDUtilisateursController extends AbstractController
{
    #[Route('/utilisateurs', name: 'app_admin_utilisateur')]
    public function utilisateurs(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateurs = $utilisateurRepository->findAll();

        return $this-> render('crud/utilisateurs.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

}
