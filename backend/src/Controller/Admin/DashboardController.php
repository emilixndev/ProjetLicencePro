<?php

namespace App\Controller\Admin;

use App\Entity\Material;
use App\Entity\MaterialType;
use App\Entity\Reservation;
use App\Entity\Supplier;
use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Budget;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\MenuItemTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractDashboardController
{


    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $materialRepo = $this->entityManager->getRepository(Material::class);
        $materialCount = $materialRepo->count([]);
        $reservationRepo = $this->entityManager->getRepository(Reservation::class);
        $reservationCount = $reservationRepo->count([]);
        $brandRepo = $this->entityManager->getRepository(Brand::class);
        $brandCount = $brandRepo->count([]);
        $catRepo = $this->entityManager->getRepository(MaterialType::class);
        $catCount = $catRepo->count([]);
        $budgetRepo = $this->entityManager->getRepository(Budget::class);
        $budgetCount = $budgetRepo->count([]);
        $userRepo = $this->entityManager->getRepository(User::class);
        $userCount = $userRepo->count([]);

return $this->render('backend/dashboard.html.twig', [
    'materialCount' => $materialCount,
    'reservationCount' => $reservationCount,
    'brandCount' => $brandCount,
    'catCount' => $catCount,
    'budgetCount' => $budgetCount,
    'userCount' => $userCount,
]);
    
    
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LabStock')->disableDarkMode();
            
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

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
            yield MenuItem::linkToCrud('Budgets', 'fas fa-sack-dollar', Budget::class);

        yield MenuItem::section('');


        yield MenuItem::linkToCrud('Réservations', 'fas fa-calendar-days', Reservation::class);

    }
}
