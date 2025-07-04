<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CRUDCompetenceController extends AbstractController
{
    #[Route('/competences', name: 'app_crud_competence')]
    public function index(): Response
    {
        return $this->render('crud/competence.html.twig');
    }
}
