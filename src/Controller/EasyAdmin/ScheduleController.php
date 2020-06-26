<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Controller\EasyAdmin\Handler\BuildingHandler;
use App\Controller\EasyAdmin\Handler\CabinetHandler;
use App\Controller\EasyAdmin\Handler\CourseHandler;
use App\Controller\EasyAdmin\Handler\FacultyHandler;
use App\Controller\EasyAdmin\Handler\PartyHandler;
use App\Controller\EasyAdmin\Handler\TeacherHandler;
use App\Controller\EasyAdmin\Handler\UniversityHandler;
use App\Controller\EasyAdmin\Handler\UniversityTimeHandler;
use App\Controller\EasyAdmin\Handler\WeekHandler;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;
use App\Service\Access\AccessService;
use App\Service\Access\PartyAccess;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScheduleController extends AdminController
{
    protected $universityRepo;
    protected $buildingRepo;
    protected $cabinetRepo;
    protected $partyRepo;
    protected $teacherRepo;
    protected $scheduleRepo;
    protected $universityTimeRepo;
    protected $weekRepo;
    protected $translator;

    protected $facultyHandler;
    protected $courseHandler;
    protected $buildingHandler;
    protected $teacherHandler;
    protected $partyHandler;
    protected $weekHandler;
    protected $universityTimeHandler;
    protected $cabinetHandler;

    private $validIds = [];
    private $user;

    public function __construct(PartyHandler $partyHandler, WeekHandler $weekHandler, UniversityTimeHandler $universityTimeHandler , CabinetHandler $cabinetHandler, TeacherHandler $teacherHandler, UniversityHandler $universityHandler, BuildingHandler $buildingHandler, CourseHandler $courseHandler, FacultyHandler $facultyHandler, TranslatorInterface $translator, WeekRepository $weekRepository, UniversityTimeRepository $universityTimeRepository, ScheduleRepository $scheduleRepository, TeacherRepository $teacherRepository, PartyRepository $partyRepository, AccessService $accessService, UniversityRepository $universityRepo, CabinetRepository $cabinetRepository, BuildingRepository $buildingRepository)
    {
        parent::__construct($translator, $universityHandler, $accessService);
        //Repository
        $this->buildingRepo = $buildingRepository;
        $this->universityRepo = $universityRepo;
        $this->cabinetRepo = $cabinetRepository;
        $this->partyRepo = $partyRepository;
        $this->teacherRepo = $teacherRepository;
        $this->scheduleRepo = $scheduleRepository;
        $this->weekRepo = $weekRepository;
        $this->universityTimeRepo = $universityTimeRepository;
        //Handler
        $this->facultyHandler = $facultyHandler;
        $this->courseHandler = $courseHandler;
        $this->buildingHandler = $buildingHandler;
        $this->teacherHandler = $teacherHandler;
        $this->partyHandler = $partyHandler;
        $this->weekHandler = $weekHandler;
        $this->universityTimeHandler = $universityTimeHandler;
        $this->cabinetHandler = $cabinetHandler;
    }

    /**
     * @return QueryBuilder Faculty query
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        $partyIds = $this->accessService->getAccessObject($this->getUser())->getAccessiblePartyIds();
        $response->andWhere('entity.party IN (:partyIds)')->setParameter('partyIds', $partyIds);
        $response->addOrderBy('entity.party', 'ASC');
        $response->addOrderBy('entity.day', 'ASC');

        return $response;
    }

    private function init()
    {
        $this->validIds = $this->accessService->getAccessObject($this->getUser())->getAccessibleScheduleIds();
        $this->user = $this->getUser();
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'Schedule', PartyAccess::getAccessRole());
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'Schedule', PartyAccess::getAccessRole());
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
        $this->init();
        $request = $this->request->request->get('schedule');

        $universityId = ArrayHelper::getValue($request, 'university');

        /**@var Schedule $entity*/
        $buildingValid = $this->buildingHandler->checkEntityExist(ArrayHelper::getValue($entity, 'cabinet.building.id'), $universityId);
        $cabinetValid = $this->cabinetHandler->checkEntityExist(ArrayHelper::getValue($entity, 'cabinet.id'), ArrayHelper::getValue($entity, 'cabinet.building.id'));
        $partyValid = $this->partyHandler->checkEntityExist(ArrayHelper::getValue($entity, 'party.id'), ArrayHelper::getColumn($entity->teacher->university->faculties, 'id'));
        $teacherValid = $this->teacherHandler->checkEntityExist(ArrayHelper::getValue($entity, 'teacher.id'), $universityId);
        $timeValid = $this->universityTimeHandler->checkEntityExist(ArrayHelper::getValue($entity, 'universityTime.id'), $universityId);

        if (!$buildingValid || !$cabinetValid || !$partyValid || !$teacherValid || !$timeValid) {
            $this->addFlash('warning', $this->translator->trans('validation_error'));
            return false;
        }

        if($this->request->query->get('action') === 'new' && $scheduleModel = $this->scheduleRepo->checkUniqueEntity($entity) ) {
            $this->addFlash('warning', $this->translator->trans('group_existing', ['group' => $scheduleModel->party->name]));
            return false;
        }

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
        $this->init();
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        /*DATA FOR SELECT*/
        $universityToChoice = $this->universityHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'cabinet.building.university.id'), $this->user);
        $teacherToChoice = $this->teacherHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'teacher.id'), $this->user, $universityToChoice[0]->id);
        $buildingsToChoice = $this->buildingHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'cabinet.building.id'), $this->user, $universityToChoice[0]->id);
        $weekToChoice = $this->weekHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'week.id'), $this->user, $universityToChoice[0]->id);
        $partyToChoice = $this->partyHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'party.id'), $this->user, $universityToChoice[0]->id);
        $timeToChoice = $this->universityTimeHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'universityTime.id'), $this->user, $universityToChoice[0]->id);

        //Get buildingId and cabinet to choice
        $buildingId = ArrayHelper::getValue($entity, 'cabinet.building.id') ?: ArrayHelper::getValue(current($buildingsToChoice), 'id');
        $cabinetToChoice = $this->cabinetHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'cabinet.id'), $this->user, $buildingId);

        $formBuilder->add('university', EntityType::class, [
            'choices' => $universityToChoice,
            'class' => 'App\Entity\University',
            'attr' => ['data-widget' => 'select2'],
            'mapped' => false,
        ])->add('building', EntityType::class, [
            'choices' => $buildingsToChoice,
            'class' => 'App\Entity\Building',
            'attr' => ['data-widget' => 'select2'],
            'mapped' => false,
        ])->add('cabinet', EntityType::class, [
            'choices' => $cabinetToChoice,
            'class' => 'App\Entity\Cabinet',
            'attr' => ['data-widget' => 'select2'],
        ])->add('party', EntityType::class, [
            'choices' => $partyToChoice,
            'class' => 'App\Entity\Party',
            'attr' => ['data-widget' => 'select2']
        ])->add('teacher', EntityType::class, [
            'choices' => $teacherToChoice,
            'class' => 'App\Entity\Teacher',
            'attr' => ['data-widget' => 'select2']
        ])->add('universityTime', EntityType::class, [
            'choices' => $timeToChoice,
            'class' => 'App\Entity\UniversityTime',
            'attr' => ['data-widget' => 'select2']
        ])->add('week', EntityType::class, [
            'choices' => $weekToChoice,
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
            $this->addToForm($form, 'building', $this->buildingRepo->findBy(['id' => $data['building']]),Building::class, false);
            $form->remove('cabinet');
            $this->addToForm($form, 'cabinet', $this->cabinetRepo->findBy(['id' => $data['cabinet']]),Cabinet::class);
            $form->remove('teacher');
            $this->addToForm($form, 'teacher', $this->teacherRepo->findBy(['id' => $data['teacher']]),Teacher::class);
            $form->remove('party');
            $this->addToForm($form, 'party', $this->partyRepo->findBy(['id' => $data['party']]),Party::class);
            $form->remove('week');
            try {
                $this->addToForm($form, 'week', $this->weekRepo->findBy(['id' => $data['week']]),Week::class);
            } catch (\Exception $e) {

            }
            $form->remove('universityTime');
            $this->addToForm($form, 'universityTime', $this->universityTimeRepo->findBy(['id' => $data['universityTime']]),UniversityTime::class);
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