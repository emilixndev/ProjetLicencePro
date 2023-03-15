<?php

namespace App\Controller\Admin;

use App\Entity\Material;
use App\Entity\MaterialType;
use App\Entity\Reservation;
use App\Entity\Supplier;
use App\Entity\User;
use App\Entity\Brand;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\MenuItemTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         return $this->render('backend/dashboard.html.twig');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LabStock')->disableDarkMode();
            
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        $isAdmin = $this->isGranted('ROLE_ADMIN');
        yield MenuItem::section('Administration');
        yield MenuItem::subMenu('Réglage utilisateur', 'fa fa-cog')->setSubItems([
            MenuItem::linkToRoute('Changer de mot de passe', 'fa fa-lock','resetUserPassword'),
            MenuItem::linkToCrud('Changer les informations', 'fa fa-user', User::class)
            ->setAction(Action::EDIT)
            ->setEntityId($this->getUser()->getId())
            ,
        ]);



        if($isAdmin){
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        }
        yield MenuItem::section('Gestion matériel');

            yield MenuItem::linkToCrud('Matériels', 'fas fa-laptop', Material::class);
        yield MenuItem::linkToCrud('Fournisseurs', 'fas fa-truck', Supplier::class);

            yield MenuItem::linkToCrud('Catégories', 'fas fa-list', MaterialType::class);
            yield MenuItem::linkToCrud('Marques', 'fas fa-tag', Brand::class);

        yield MenuItem::section('');


        yield MenuItem::linkToCrud('Réservations', 'fas fa-calendar-days', Reservation::class);

    }
}
