<?php

namespace App\Controller\EasyAdmin;

use App\Service\Access\UniversityAccess;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class WeekController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class WeekController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleWeekIds();
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $this->init();
        $response->andWhere('entity.id IN (:ids)')->setParameter('ids', $this->validIds);
        return $response;
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'Week', [UniversityAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Week', [UniversityAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Week', [UniversityAccess::getAccessRole()]);
    }

    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $unToSel = $this->selDataHandler->getDataUn(null);
        $formBuilder->add('university', EntityType::class, [
            'choices' => $unToSel,
            'class' => 'App\Entity\University',
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}