<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Brand::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
            return $action->displayIf(function (Brand $brand){
                if(count($brand->getMaterials())===0){
                    return true;
                }
                return false;
            });
            return $action;
        });
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
    }
    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true);
        return $crud;

    }
}
