<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParametreRepository;
use App\Entity\Parametre;
use App\Entity\Participation;
use App\Entity\Salle;
use App\Entity\Service;
use App\Entity\Session;
use App\Entity\Visibilite;
use App\Entity\Utilisateur;

#[AdminDashboard(routePath: '/admin', routeName: 'app_admin')]
class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_RH')]
    public function index(): Response
    {
        return $this->render('admin/admin_dashboard.html.twig', [
        ]);
    }

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard - AppFormation')
            ->setFaviconPath('img/logo.png')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Formations', 'fas fa-book', Formation::class);
        yield MenuItem::linkToCrud('Sessions', 'fas fa-list', Session::class);
        yield MenuItem::linkToCrud('Participations', 'fas fa-check-square', Participation::class);
        yield MenuItem::linkToCrud('Visibilités', 'fas fa-eye', Visibilite::class);

        if($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Utilisateur::class);
            yield MenuItem::linkToCrud('Services', 'fas fa-id-badge', Service::class);
            yield MenuItem::linkToCrud('Salles', 'fas fa-map-marker', Salle::class);
        }
    }

    #[Route('/admin/update-colors', name: 'app_admin_update_colors', methods: ['POST'])]
    public function updateColors(
        Request $request,
        ParametreRepository $parametreRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $colorKeys = ['background_color', 'primary_color', 'utility_button', 'warning_button', 'login_background_color'];

        foreach ($colorKeys as $key) {
            $value = $request->request->get($key);
            if (!$value || !preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
                continue; // Ignore ou log une erreur si tu veux
            }

            $param = $parametreRepository->findOneBy(['nom' => $key]);

            if (!$param) {
                $param = new Parametre();
                $param->setNom($key);
            }

            $param->setValeur($value);
            $entityManager->persist($param);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
