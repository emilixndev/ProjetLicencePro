<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;


use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;



class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true)
            ->setEntityLabelInSingular('utilisateur')
            ->setEntityLabelInPlural('utilisateurs')
            ->setPageTitle('index', 'Gestion des utilisateurs')
            ->setPageTitle('edit', 'Modifier un utilisateur')
            ->setPageTitle('new', 'Créer un nouveau utilisateur')
            ->setPageTitle("detail","Détails de l'utilisateur");
        return $crud;

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


        $actions->setPermission(Action::SAVE_AND_RETURN,'ROLE_ADMIN');


        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');

        yield TextField::new('password')->onlyWhenCreating();

        yield TextField::new('firstName','Prénom');
        yield TextField::new('lastName','Nom');
        yield TextField::new('tel');
        yield ChoiceField::new('roles','Roles')
            ->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'Owner' => 'ROLE_OWNER',
            ])
            ->allowMultipleChoices()
            ->setPermission('ROLE_ADMIN')
        ;

    }


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {

        if($this->isGranted("ROLE_ADMIN")){
            return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        }
        throw new \Exception("Non autorisé");
    }



    


}
