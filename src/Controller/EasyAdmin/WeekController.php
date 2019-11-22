<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Schedule;
use App\Helper\ArrayHelper;
use App\Service\Access\UniversityAccessService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Week', UniversityAccessService::getAccessRole());
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Week', UniversityAccessService::getAccessRole());
    }

    /**
     * Rewriting standard easy admin function
     * @param Schedule $entity
     * @param string $view
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function createEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $universityToChoice = $this->universityHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'university.id'), $this->getUser());

        $formBuilder->add('university', EntityType::class, [
            'choices' => $universityToChoice,
            'class' => 'App\Entity\University',
            'attr' => ['data-widget' => 'select2'],
        ]);

        return $formBuilder;
    }
}