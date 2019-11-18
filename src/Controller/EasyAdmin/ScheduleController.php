<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Handler\BuildingHandler;
use App\Handler\CabinetHandler;
use App\Handler\CourseHandler;
use App\Handler\FacultyHandler;
use App\Handler\PartyHandler;
use App\Handler\TeacherHandler;
use App\Handler\UniversityHandler;
use App\Handler\UniversityTimeHandler;
use App\Handler\WeekHandler;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;
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

        $partyIds = $this->accessService->getPartyPermission($this->getUser());
        $response->andWhere('entity.party IN (:partyIds)')->setParameter('partyIds', $partyIds);

        return $response;
    }

    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = $this->accessService->getSchedulePermission($this->getUser());
        return $this->listCheckPermissionAndRedirect($validIds, 'Schedule', AccessService::ROLE_PARTY_MANAGER);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = $this->accessService->getSchedulePermission($this->getUser());
        return $this->editCheckPermissionAndRedirect($validIds, 'Schedule', AccessService::ROLE_PARTY_MANAGER);
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
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        /*DATA FOR SELECT*/
        $universityToChoice = $this->universityHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'cabinet.building.university.id'), $this->getUser());
        $teacherToChoice = $this->teacherHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'teacher.id'), current($universityToChoice));
        $buildingsToChoice = $this->buildingHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'cabinet.building.id'), current($universityToChoice));
        $weekToChoice = $this->weekHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'week.id'), current($universityToChoice));
        $partyToChoice = $this->partyHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'party.id'), current($universityToChoice));
        $timeToChoice = $this->universityTimeHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'universityTime.id'), current($universityToChoice));
        $cabinetToChoice = $this->cabinetHandler->setSelect2EasyAdmin(ArrayHelper::getValue($entity, 'cabinet.id'), current($buildingsToChoice));

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
            'required' => false,
            'attr' => ['data-widget' => 'select2'],
            'disabled' => (ArrayHelper::getValue($entity, 'week.id') == false),
        ])->add('week_enable', CheckboxType::class, [
            'label' => 'Lesson every week',
            'required' => false,
            'mapped' => false,
            'data' => (ArrayHelper::getValue($entity, 'week.id') == false)
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