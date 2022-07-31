<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\LegalStatus;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(CompanyCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Inter Invest Test');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section(null);
        yield MenuItem::linkToCrud('Companies', 'fa fa-building', Company::class);
        yield MenuItem::linkToCrud('Legal Status', 'fa-solid fa-gavel', LegalStatus::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);

        yield MenuItem::section(null);
        yield MenuItem::linkToRoute('Retour au site', 'fa-solid fa-house', 'home');
    }
}
