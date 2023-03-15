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

        yield TextField::new('name');
        yield TextField::new('address');
        yield TextField::new('postalCode');
        yield TextField::new('city');
        yield EmailField::new('email');
        yield TextField::new('phone');


    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true);

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
