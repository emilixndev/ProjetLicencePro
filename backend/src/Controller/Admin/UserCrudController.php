<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\Security\Core\Security;


use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;


class UserCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->hashPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->hashPassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }
    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true);
        return $crud;

    }
    private function hashPassword($entity)
    {
        $plainPassword = $entity->getPassword();
        if (!empty($plainPassword)) {
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
            $entity->setPassword($hashedPassword);
        }

    }

    public function configureFilters(Filters $filters): Filters
    {

        $filters->add("email")
            ->add(ChoiceFilter::new('roles')->setChoices(
                [
                    'Admin' => 'ROLE_ADMIN',
                    'Owner' => 'ROLE_OWNER',
                ]
            ))
            ->add('firstName')
            ->add('lastName')
            ->add('tel');


        return $filters;
    }

    public function configureActions(Actions $actions): Actions
    {
        $impersonate = Action::new('impersonate', 'Impersonate')
            ->linkToUrl(function (User $user): string {
                return '?_switch_user=' . $user->getEmail();
            });
        if ($this->isGranted("ROLE_ADMIN")) {
            $actions->add(Crud::PAGE_INDEX, $impersonate);
        }

        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');

        yield TextField::new('password')->onlyWhenCreating();
        yield ChoiceField::new('roles')->setChoices([
            'Admin' => 'ROLE_ADMIN',
            'Owner' => 'ROLE_OWNER',
        ])->allowMultipleChoices();
        yield TextField::new('firstname');
        yield TextField::new('lastname');
        yield TextField::new('tel');


    }


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {

        if($this->isGranted("ROLE_ADMIN")){
            return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        }
        throw new \Exception("Non autorisé");
    }


}
