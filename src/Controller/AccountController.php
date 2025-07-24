<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;
use App\Repository\ParametreRepository;


final class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ParametreRepository $parametreRepository
    ): Response
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();

        if ($request -> isMethod('POST')){
                $oldPassword = $request->request->get('_old_password');
                $newPassword = $request->request->get('_new_password');
                $confirmPassword = $request->request->get('_confirm_password');

                if (!$passwordHasher->isPasswordValid($utilisateur, $oldPassword)) {
                    $this->addFlash('error', 'L\'ancien mot de passe est incorrect.');
                }

                elseif ($newPassword == $oldPassword){
                    $this->addFlash('error', 'L\'ancien et le nouveau mot de passe sont similaires');
                }

                elseif ($newPassword != $confirmPassword){
                    $this->addFlash('error', 'Les nouveaux mots de passes ne correspondent pas');
                }

                else {
                    $hashedPassword = $passwordHasher->hashPassword($utilisateur, $newPassword);
                    $utilisateur->setPassword($hashedPassword);
                    $entityManager->flush();

                    $this->addFlash('success', 'Mot de passe mis à jour avec succès.');
                    return $this->redirectToRoute('app_account');
                }
            }

        $backgroundColor = $parametreRepository
            ->findOneBy(['nom' => 'background_color'])
            ?->getValeur() ?? '#ffffff';

        return $this->render('account/account.html.twig', [
            'background_color' => $backgroundColor,
        ]);
    }
}
