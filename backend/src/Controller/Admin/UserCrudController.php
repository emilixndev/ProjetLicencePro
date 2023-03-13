<?php

namespace App\Controller\Admin;
use Doctrine\ORM\QueryBuilder;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Security\Core\Security;


use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;




class UserCrudController extends AbstractCrudController
{
    private $entityManager;
    private $security;

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

    private function hashPassword($entity)
    {
        $plainPassword = $entity->getPassword();
        if (!empty($plainPassword)) {
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
            $entity->setPassword($hashedPassword);
        }

    }
    public function configureActions(Actions $actions): Actions
    {
        $user = $this->getUser();
    
        // Vérifier si l'utilisateur connecté a le rôle "ROLE_ADMIN"
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $actions;
        }
    
        // Si l'utilisateur n'a pas le rôle "ROLE_ADMIN", supprimer l'action "Nouveau"
        return $actions
            ->disable(Action::NEW);
    }



    public function configureFields(string $pageName): iterable
{
    yield IdField::new('id')->hideOnForm()->hideOnIndex();
    yield TextField::new('email');
    yield TextField::new('password')->hideOnIndex();;
    yield ChoiceField::new('roles')->setChoices([
        'Admin' => 'ROLE_ADMIN',
        'Owner' => 'ROLE_OWNER',
    ])->allowMultipleChoices();
    // ...
}


}
