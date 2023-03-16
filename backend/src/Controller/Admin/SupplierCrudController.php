<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Supplier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class SupplierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Supplier::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add('name')
            ->add('address')
            ->add('postalCode')
            ->add('city')
            ->add('email')
            ->add('phone');


        return $filters;
    }


    public function configureFields(string $pageName): iterable
    {

        yield TextField::new('name','Nom');
        yield TextField::new('address',"Adresse");
        yield TextField::new('postalCode','Code postal');
        yield TextField::new('city','Ville');
        yield EmailField::new('email','Email');
        yield TextField::new('phone','Tel');


    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true)
            ->setEntityLabelInSingular('Fournisseur')
            ->setEntityLabelInPlural('Fournisseurs')
            ->setPageTitle('index', 'Gestion des fournisseurs')
            ->setPageTitle('edit', 'Modifier un fournisseur')
            ->setPageTitle('new', 'Créer un nouveau fournisseur')
            ->setPageTitle('detail','Détails du fournisseur');

        return $crud;

    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
            return $action->displayIf(function (Supplier $supplier){
                if(count($supplier->getMaterials())===0){
                    return true;
                }
                return false;
            });
            return $action;
        });
        return $actions;
    }
}
