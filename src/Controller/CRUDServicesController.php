<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CRUDServicesController extends AbstractController
{
    #[Route('/services', name: 'app_crud_service')]
    public function index(): Response
    {
        return $this->render('crud/services.html.twig', [
            'controller_name' => 'CRUDServicesController',
        ]);
    }
}
