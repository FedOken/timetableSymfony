<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Controller\EasyAdmin\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\DayRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Service\Access\AccessService;
use App\Service\Access\UniversityAccess;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validation;

class UniversityTimeController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleTimeIds();
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
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Time', UniversityAccess::getAccessRole());
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Time', UniversityAccess::getAccessRole());
    }

    /**
     * Action Edit, on update
     * @param UniversityTime $entity
     */
    protected function updateEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * Action New, on save
     * @param UniversityTime $entity
     */
    protected function persistEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * @param UniversityTime $entity
     * @return bool
     */
    private function beforeSave($entity) {
        $entity->setName();

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
        return true;
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