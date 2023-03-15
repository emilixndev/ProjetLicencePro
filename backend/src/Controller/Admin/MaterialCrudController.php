<?php

namespace App\Controller\Admin;

use App\Entity\Material;
use App\Form\MaterialImgType;
use App\Repository\UserRepository;
use App\Service\csvGenerator;
use Doctrine\ORM\QueryBuilder;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;


use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Symfony\Component\Security\Core\Security;


class MaterialCrudController extends AbstractCrudController
{


    public function __construct(
        private EntityManagerInterface        $entityManager,
        private Security                      $security,
        private readonly AdminContextProvider $adminContextProvider,
        private csvGenerator                  $csvGenerator,
    )
    {
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->showEntityActionsInlined(true);

        return $crud;

    }

    public function configureFilters(Filters $filters): Filters
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            $filters->add('user');
        }
        $filters
            ->add("name")
            ->add("BCnumber")
            ->add(BooleanFilter::new('isAvaible'))
            ->add('budget')
            ->add(DateTimeFilter::new('deleveryDate'))
            ->add(DateTimeFilter::new('endOfGuarantyDate'))
            ->add('InventoryNumber')
            ->add('supplier')
            ->add('brand')
            ->add('materialTypes');
        return $filters;
    }

    public static function getEntityFqcn(): string
    {
        return Material::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        $exportXlsx = Action::new('exportCSV', 'export CSV')
            ->setIcon('fa fa-download')
            ->linkToCrudAction('exportCSV')
            ->setCssClass('btn btn-success')
            ->createAsGlobalAction();

        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $exportXlsx);
        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        yield BooleanField::new('isAvailable');
        yield TextField::new('name');
        yield TextareaField::new('description')->hideOnIndex();
        yield AssociationField::new('supplier', 'Fournisseur')->formatValue(function ($value, $entity) {
            return $entity->getSupplier()->getName();
        });;
        if ($this->isGranted("ROLE_ADMIN")) {
            yield AssociationField::new('user', 'Propriétaire');
        }
        if (!$this->isGranted("ROLE_ADMIN")) {
            yield AssociationField::new('user', 'Propriétaire')
                ->setFormTypeOptions(['query_builder' => function (UserRepository $em) {
                    if (!$this->isGranted('ROLE_ADMIN')) {
                        return $em->createQueryBuilder('user')
                            ->andWhere('user.email = :email')
                            ->setParameter('email', $this->getUser()->getEmail());

                    }
                    return $em->createQueryBuilder('user');
                }])->onlyOnForms();
        }

        yield CollectionField::new('ImgMaterials')
            ->setEntryType(MaterialImgType::class)
            ->onlyOnForms();
        yield CollectionField::new('ImgMaterials')
            ->onlyOnDetail()
            ->setTemplatePath("backend/custom/imgMaterials.html.twig");


        yield DateField::new('deleveryDate');
        yield DateField::new('endOfGuarantyDate');

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
        yield AssociationField::new('budget');

        yield TextField::new('InventoryNumber');

        yield TextField::new('BCnumber', 'BC number');
        yield TextField::new('link');

    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        }
        return $response->andWhere('entity.user = :id_utilisateur')->setParameter('id_utilisateur', $this->getUser()->getId());
    }


    public function exportCSV(FilterFactory $filterFactory)
    {

        $context = $this->adminContextProvider->getContext();

        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $filterFactory->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());

        $materials = $this->createIndexQueryBuilder(
            $context->getSearch(), $context->getEntity(), $fields, $filters
        )
            ->getQuery()->getResult();
        $materialsFormated = [];
        /** @var Material $material */
        foreach ($materials as $material) {
            $materialsFormated [] = $material->getExportedData();
        }
        return $this->csvGenerator->export($materialsFormated, "export_" . date("Y-m-d") . ".csv");
    }


}