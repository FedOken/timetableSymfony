<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Party;
use App\Controller\EasyAdmin\Handler\BuildingHandler;
use App\Controller\EasyAdmin\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Service\Access\AccessService;
use App\Service\Access\FacultyAccess;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Contracts\Translation\TranslatorInterface;


class CabinetController extends AdminController
{
    protected $buildingHandler;
    private $validIds = [];

    public function __construct(BuildingHandler $buildingHandler, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);
        $this->buildingHandler = $buildingHandler;
    }

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleCabinetIds();
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $this->init();
        $response->andWhere('entity.id IN (:ids)')->setParameter('ids', $this->validIds);
        $response->addOrderBy('entity.building', 'ASC');
        $response->addOrderBy('entity.name', 'ASC');
        return $response;
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Cabinet', FacultyAccess::getAccessRole());
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Cabinet', FacultyAccess::getAccessRole());
    }

    /**
     * Rewriting standard easy admin function
     * @param Party $entity
     * @param string $view
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $buildingToChoice = $this->buildingHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'building.id'), $this->getUser());

        $formBuilder->add('building', EntityType::class, [
            'choices' => $buildingToChoice,
            'class' => 'App\Entity\Building',
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}