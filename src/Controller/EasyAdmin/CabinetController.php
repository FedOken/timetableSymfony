<?php

namespace App\Controller\EasyAdmin;


use App\Entity\Party;
use App\Handler\BuildingHandler;
use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Contracts\Translation\TranslatorInterface;


class CabinetController extends AdminController
{
    protected $buildingHandler;

    public function __construct(BuildingHandler $buildingHandler, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);
        //Handler
        $this->buildingHandler = $buildingHandler;
    }
    /**
     * @return QueryBuilder query
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $buildingIds = $this->accessService->getBuildingPermission($this->getUser());
        $response->andWhere('entity.building IN (:buildingIds)')->setParameter('buildingIds', $buildingIds);

        return $response;
    }

    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = $this->accessService->getCabinetPermission($this->getUser());
        return $this->listCheckPermissionAndRedirect($validIds, 'Cabinet', AccessService::ROLE_FACULTY_MANAGER);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = $this->accessService->getCabinetPermission($this->getUser());
        return $this->editCheckPermissionAndRedirect($validIds, 'Cabinet', AccessService::ROLE_FACULTY_MANAGER);
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