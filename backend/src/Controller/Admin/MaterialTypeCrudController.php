<?php

namespace App\Controller\Admin;

use App\Entity\MaterialType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaterialTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaterialType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true)
            ->setEntityLabelInSingular('Catégories')
            ->setPageTitle('index', 'Gestion des catégories')
            ->setPageTitle('edit', 'Modifier une catégorie')
            ->setPageTitle('new', 'Créer une catégorie')
            ->setPageTitle('detail', 'Détails catégorie');
        return $crud;

    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name','Nom');
    }

}
