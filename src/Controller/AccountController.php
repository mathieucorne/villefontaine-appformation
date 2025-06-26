<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\ParametreRepository;


final class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        ORMEntityManagerInterface $entityManager,
        ParametreRepository $parametreRepository
    ): Response
    {
        $user = $this -> getUser();

        if ($request -> isMethod('POST')){
            $oldPassword = $request->request->get('_old_password');
            $newPassword = $request->request->get('_new_password');
            $confirmPassword = $request->request->get('_confirm_password');

            if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash('error', 'L\'ancien mot de passe est incorrect.');
            }

            elseif ($newPassword == $oldPassword){
                $this->addFlash('error', 'L\'ancien et le nouveau mot de passe sont similaires');
            }

            elseif ($newPassword != $confirmPassword){
                $this->addFlash('error', 'Les nouveaux mots de passes ne correspondent pas');
            }

            else {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $entityManager->flush();

                $this->addFlash('success', 'Mot de passe mis à jour avec succès.');
                return $this->redirectToRoute('app_account');
            }

        }

        return $this->render('account/account.html.twig', [
            'background_color' => $backgroundColor,
        ]);
    }
}
