<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;

class ReservationCrudController extends AbstractCrudController
{

    private $entityManager;

    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true);
        return $crud;

    }

    public function configureActions(Actions $actions): Actions
    {

        // Vérifier si l'utilisateur connecté a le rôle "ROLE_ADMIN"


        // Si l'utilisateur n'a pas le rôle "ROLE_ADMIN", supprimer l'action "Nouveau"
        return $actions
            ->disable(Action::NEW)
            ->disable(Action::EDIT);

    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function configureFields(string $pageName): iterable
    {


        yield IdField::new('id')->HideOnForm();
        yield TextField::new('firstName');
        yield TextField::new('LastName');
        yield DateField::new('startDate');
        yield DateField::new('endDate');
        yield TextField::new('emailBorrower');
        yield TextField::new('statutBorrower');
        yield AssociationField::new('material', 'Materiel')->formatValue(function ($value, $entity) {
            return $entity->getMaterial()->getName();
        });
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $user = $this->getUser(); // récupère l'utilisateur connecté

        $qb = $this->entityManager->createQueryBuilder()
            ->select('entity')
            ->from($entityDto->getFqcn(), 'entity')
            ->join('entity.material', 'material')
            ->join('material.user', 'user')
            ->where('user = :user')
            ->setParameter('user', $user);

        return $qb;
    }

}
