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
            ->setEntityLabelInSingular('Type de matériel')
            ->setPageTitle('index', 'Gestion des types de matériel')
            ->setPageTitle('edit', 'Modifier un type de matériel')
            ->setPageTitle('new', 'Créer un nouveau type de matériel')
            ->setPageTitle('detail', 'Détails du type de matériel');
        return $crud;

    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name','Nom');
    }

}
