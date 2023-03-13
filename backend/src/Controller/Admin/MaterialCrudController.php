<?php

namespace App\Controller\Admin;
use App\Entity\Material;
use Doctrine\ORM\QueryBuilder;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;


use Symfony\Component\Security\Core\Security;


class MaterialCrudController extends AbstractCrudController
{
    private $entityManager;
    private $security;



public function __construct(EntityManagerInterface $entityManager, Security $security)
{
    $this->entityManager = $entityManager;
    $this->security = $security;
}

    public static function getEntityFqcn(): string
    {
        return Material::class;
    }
    public function configureFields(string $pageName): iterable

    {

        $isEditableByAdmin = $this->isGranted('ROLE_ADMIN');



        yield IdField::new('id')->hideOnForm()->hideOnIndex();;
        yield TextField::new('name');
        yield TextareaField::new('description')->hideOnIndex();
        yield BooleanField::new('isAvailable');
        $proprietaireField = AssociationField::new('user', 'Propriétaire');

        if ($isEditableByAdmin) {
            yield $proprietaireField
                ->setFormTypeOption('disabled', false)
                ->setFormTypeOption('required', true)
                ->setCustomOption('admin_can_edit', true);
        } else {
            yield $proprietaireField
                ->setFormTypeOption('disabled', false)
                ->setFormTypeOption('required', true)
                ->setFormTypeOption('data', $this->getUser());
        }

        yield AssociationField::new('budget');
        yield TextField::new('BCnumber','BC number');
        yield DateField::new('deleveryDate');
        yield DateField::new('endOfGuarantyDate');
        yield TextField::new('InventoryNumber');
        yield AssociationField::new('supplier', 'Fournisseur')->formatValue(function ($value, $entity) {
            return $entity->getSupplier()->getName();
        });;
        yield AssociationField::new('reservations', 'Reservations')->hideOnForm();
        yield AssociationField::new('brand', 'Marque');
        yield AssociationField::new('materialTypes', 'Type de matériel')
        ->formatValue(function ($value, $entity) {
            $types = [];
            foreach ($entity->getMaterialTypes() as $type) {
                $types[] = $type->getName();
            }
            return implode(', ', $types);
        })
        ->setCrudController(MaterialTypeCrudController::class)->setFormTypeOption('by_reference', false);
        
}
public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
{
    $qb = $this->entityManager->createQueryBuilder();

    if ($this->security->isGranted('ROLE_ADMIN')) {
        $qb->select('entity')
            ->from($entityDto->getFqcn(), 'entity');
    } else {
        $qb->select('entity')
            ->from($entityDto->getFqcn(), 'entity')
            ->where('entity.user = :id_utilisateur')
            ->setParameter('id_utilisateur', $this->getUser()->getId());
    }

    return $qb;
}



}