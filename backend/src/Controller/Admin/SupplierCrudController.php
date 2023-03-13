<?php

namespace App\Controller\Admin;

use App\Entity\Supplier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class SupplierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Supplier::class;
    }

    
    public function configureFields(string $pageName): iterable
    {

            yield TextField::new('name');
            yield TextField::new('adress');
            yield TextField::new('postalCode');
            yield TextField::new('city');
            yield TextField::new('email');
            yield TextField::new('phone');
            yield AssociationField::new('materials', 'Matériels');
      

    }
}
