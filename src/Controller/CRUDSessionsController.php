<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CRUDSessionsController extends AbstractController
{
    #[Route('/sessions', name: 'app_crud_session')]
    public function index(): Response
    {
        return $this->render('crud/sessions.html.twig');
    }
}
