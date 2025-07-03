<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FormationRepository;
use App\Repository\ParametreRepository;
use App\Entity\Formation;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


final class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository, ParametreRepository $parametreRepository): Response
    {
        $backgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'background_color'])
            ?->getValeur() ?? '#ffffff';

        $formation = $formationRepository
            ->findAll();

        return $this->render('formation/formation.html.twig', [
            'background_color' => $backgroundColor,
            'formations' => $formation
        ]);
    }
    #[Route('/formation/creer', name: 'app_formation_creer', methods: ['POST'])]
    public function creer(Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $titre = $request->request->get('titre');
        $description = $request->request->get('description');
        $estVisible = $request->request->get('estVisible') ? true : false;

        if (!$titre) {
         $this->addFlash('error', 'Le titre est obligatoire.');
            return $this->redirectToRoute('app_formation');
        }

        $formation = new Formation();
        $formation->setTitre($titre);
        $formation->setDescription($description);
        $formation->setEstVisible($estVisible);

        $em->persist($formation);
        $em->flush();

        $this->addFlash('success', 'Formation créée avec succès.');

        return $this->redirectToRoute('app_formation');
    }

}
