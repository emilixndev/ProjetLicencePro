<?php

namespace App\Controller\Admin;

use App\Entity\Material;
use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
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
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;

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
            ->showEntityActionsInlined(true)
            ->setEntityLabelInSingular('Réservation')
            ->setEntityLabelInPlural('Réservations')
            ->setPageTitle('index', 'Gestion des réservations')
            ->setPageTitle('edit', 'Modifier une réservation')
            ->setPageTitle('new', 'Créer une nouvelle réservation')
            ->setPageTitle("detail","Détails d'une réservation");
        return $crud;

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
            ->disable(Action::EDIT);

    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add('emailBorrower')
            ->add(ChoiceFilter::new('statutBorrower')
                ->setChoices([
                    'perma'=>'Perma',
                    'Doc'=>'Doc',
                    'PostDoc'=>'PostDoc',
                    'Etudiant'=>'Etudiant',
                    'EXT'=>'EXT']))
            ->add('material')
            ->add(DateTimeFilter::new('endDate'))
            ->add(DateTimeFilter::new('startDate'))
            ->add('lastName')
            ->add('firstName');

        return  $filters;
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function configureFields(string $pageName): iterable
    {


        yield TextField::new('firstName','Prénom');
        yield TextField::new('lastName','Nom');
        yield DateField::new('startDate','Date de début');
        yield DateField::new('endDate','Date de fin');
        yield TextField::new('emailBorrower',"Email de l'emprunteur");
        yield TextField::new('statutBorrower',"Statut de l'emprunteur");
        yield AssociationField::new('material', 'Matériel')->formatValue(function ($value, $entity) {
            return $entity->getMaterial()->getName();
        });
        yield TextField::new('material', 'Propriétaire')
            ->formatValue(function ($value, Reservation $entity) {
            return $entity->getMaterial()->getUser()->getFirstName().
                ' '.
                $entity->getMaterial()->getUser()->getLastName();
        })
            ->setPermission("ROLE_ADMIN");
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if($this->isGranted("ROLE_ADMIN")){
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        }
        return $response
            ->leftJoin('entity.material','material')
            ->andWhere('material.user = :id_utilisateur')
            ->setParameter('id_utilisateur', $this->getUser()->getId());
    }

}
