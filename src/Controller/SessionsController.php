<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SessionsController extends AbstractController
{
    #[Route('/sessions/{id}', name: 'app_session')]
    public function index(
        Session $session
    ): Response
    {
        return $this->render('formations/session.html.twig', [
            'session' => $session
        ]);
    }
}
