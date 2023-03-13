<?php

namespace App\Controller\Admin;

use App\Entity\MaterialType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaterialTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaterialType::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
    }
    
}
