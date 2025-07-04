<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CRUDSallesController extends AbstractController
{
    #[Route('salles', name: 'app_crud_salles')]
    public function index(): Response
    {
        return $this->render('crud/salles.html.twig');
    }
}
