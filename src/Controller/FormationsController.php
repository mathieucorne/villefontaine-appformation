<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FormationsController extends AbstractController
{
    #[Route('/formations', name: 'app_formations')]
    public function index(): Response
    {
        return $this->render('formations/formations.html.twig');
    }
}
