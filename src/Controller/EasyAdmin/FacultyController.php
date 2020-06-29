<?php

namespace App\Controller\EasyAdmin;

use App\Helper\ArrayHelper;
use App\Service\Access\FacultyAccess;
use App\Service\Access\UniversityAccess;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class FacultyController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class FacultyController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleFacultyIds();
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
        return $this->newCheckPermissionAndRedirect($this->validIds, 'Faculty', [UniversityAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Faculty', [UniversityAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Faculty', [FacultyAccess::getAccessRole()]);
    }

    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $unToSel = $this->selDataHandler->getDataUn(ArrayHelper::getValue($entity, 'university.id'));
        $formBuilder->add('university', EntityType::class, [
            'choices' => $unToSel,
            'class' => 'App\Entity\University',
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}
