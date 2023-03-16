<?php

namespace App\Controller\Admin;

use App\Entity\Budget;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
class BudgetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Budget::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true)
            ->setEntityLabelInSingular('Budget')
            ->setEntityLabelInPlural('Budgets')
            ->setPageTitle('index', 'Gestion des budgets')
            ->setPageTitle('edit', 'Modifier un budget')
            ->setPageTitle('new', 'Créer un nouveau budget')
            ->setPageTitle("detail","Détails du budget");
        return $crud;

    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name','Nom');
        yield TextareaField::new('description','Description');
    }
}
