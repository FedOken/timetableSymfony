<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Helper\ArrayHelper;
use App\Repository\ScheduleRepository;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/**
 * Class ScheduleController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class ScheduleController extends AdminController
{
    private $validIds;

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $query = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        switch ($this->getUser()->roles[0]) {
            case UniversityAccess::getAccessRole():
            case FacultyAccess::getAccessRole():
            case PartyAccess::getAccessRole():
                $partyIds = $this->accessService->getAccessObject($this->getUser())->getAccessiblePartyIds();
                $query->andWhere('entity.party IN (:ids)')->setParameter('ids', $partyIds);
                break;
            case TeacherAccess::getAccessRole():
                $tchrIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleTeacherIds();
                $query->andWhere('entity.teacher IN (:ids)')->setParameter('ids', $tchrIds);
                break;
        }

        $query->addOrderBy('entity.party', 'ASC');
        $query->addOrderBy('entity.day', 'ASC');
        return $query;
    }

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleScheduleIds();
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'Schedule', [TeacherAccess::getAccessRole(), PartyAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Schedule', [TeacherAccess::getAccessRole(), PartyAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Schedule', [TeacherAccess::getAccessRole(), PartyAccess::getAccessRole()]);
    }

    /**
     * Action Edit, on update
     * @param Schedule $entity
     */
    protected function updateEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * Action New, on save
     * @param Schedule $entity
     */
    protected function persistEntity($entity)
    {
        $this->beforeSave($entity);

    }

    /**
     * @param Schedule $entity
     * @return bool
     */
    private function beforeSave($entity) {
        /** @var ScheduleRepository $schRepo */
        $schRepo = $this->em->getRepository(Schedule::class);
        if($this->request->query->get('action') === 'new' && $scheduleModel = $schRepo->checkUniqueEntity($entity) ) {
            $this->addFlash('warning', $this->translator->trans('group_existing', ['group' => $scheduleModel->party->name]));
            return false;
        }

        $this->em->persist($entity);
        $this->em->flush();
        return true;
    }

    protected function createEntityFormBuilder($entity, $view)
    {
        $this->init();
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        /*DATA FOR SELECT*/
        $unToSel = $this->selDataHandler->getDataUn(ArrayHelper::getValue($entity, 'cabinet.building.university.id'));
        $unCurrent = ArrayHelper::getValue($unToSel, '0.id');

        $tchrToSel = $this->selDataHandler->getDataTchr(ArrayHelper::getValue($entity, 'teacher.id'), $unCurrent);
        $bldngToSel = $this->selDataHandler->getDataBldng(ArrayHelper::getValue($entity, 'cabinet.building.id'), $unCurrent);
        $wkToSel = $this->selDataHandler->getDataWk(ArrayHelper::getValue($entity, 'week.id'), $unCurrent);
        $prtToSel = $this->selDataHandler->getDataPrt(ArrayHelper::getValue($entity, 'party.id'), $unCurrent);
        $unTmToSel = $this->selDataHandler->getDataUnTm(ArrayHelper::getValue($entity, 'universityTime.id'), $unCurrent);

        //Get buildingId and cabinet to choice
        $bldngCurrent = ArrayHelper::getValue($entity, 'cabinet.building.id') ?: ArrayHelper::getValue($bldngToSel, '0.id');
        $cbntToSel = $this->selDataHandler->getDataCbnt(ArrayHelper::getValue($entity, 'cabinet.id'), $bldngCurrent);

        $formBuilder->add('university', EntityType::class, [
            'choices' => $unToSel,
            'class' => 'App\Entity\University',
            'attr' => ['data-widget' => 'select2'],
            'mapped' => false,
        ])->add('building', EntityType::class, [
            'choices' => $bldngToSel,
            'class' => 'App\Entity\Building',
            'attr' => ['data-widget' => 'select2'],
            'mapped' => false,
        ])->add('cabinet', EntityType::class, [
            'choices' => $cbntToSel,
            'class' => 'App\Entity\Cabinet',
            'attr' => ['data-widget' => 'select2'],
        ])->add('party', EntityType::class, [
            'choices' => $prtToSel,
            'class' => 'App\Entity\Party',
            'attr' => ['data-widget' => 'select2']
        ])->add('teacher', EntityType::class, [
            'choices' => $tchrToSel,
            'class' => 'App\Entity\Teacher',
            'attr' => ['data-widget' => 'select2']
        ])->add('universityTime', EntityType::class, [
            'choices' => $unTmToSel,
            'class' => 'App\Entity\UniversityTime',
            'attr' => ['data-widget' => 'select2']
        ])->add('week', EntityType::class, [
            'choices' => $wkToSel,
            'class' => 'App\Entity\Week',
            'attr' => ['data-widget' => 'select2'],
        ]);

        //Listener change data in form on actual before submit. Need for form validation.
        $formBuilder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event)
        {
            $data = $event->getData();
            $form = $event->getForm();

            //Remove and add new same field, with actual data
            $form->remove('building');
            $this->addToForm($form, 'building', $this->em->getRepository(Building::class)->findBy(['id' => $data['building']]),Building::class, false);
            $form->remove('cabinet');
            $this->addToForm($form, 'cabinet', $this->em->getRepository(Cabinet::class)->findBy(['id' => $data['cabinet']]),Cabinet::class);
            $form->remove('teacher');
            $this->addToForm($form, 'teacher', $this->em->getRepository(Teacher::class)->findBy(['id' => $data['teacher']]),Teacher::class);
            $form->remove('party');
            $this->addToForm($form, 'party', $this->em->getRepository(Party::class)->findBy(['id' => $data['party']]),Party::class);
            $form->remove('week');
            $this->addToForm($form, 'week', $this->em->getRepository(Week::class)->findBy(['id' => $data['week']]),Week::class);
            $form->remove('universityTime');
            $this->addToForm($form, 'universityTime', $this->em->getRepository(UniversityTime::class)->findBy(['id' => $data['universityTime']]),UniversityTime::class);
        });

        return $formBuilder;
    }

    /*PRIVATE FUNCTION*/
    /**
     * Add new field to form
     * @param FormInterface $form
     * @param string $propertyName
     * @param object $data
     * @param string $className
     * @param bool $mapped
     */
    private function addToForm(FormInterface $form, $propertyName, $data, $className, $mapped = true)
    {
        $form->add($propertyName, EntityType::class, [
            'choices' => $data,
            'class' => $className,
            'attr' => ['data-widget' => 'select2'],
            'mapped' => $mapped,
        ]);
    }
}