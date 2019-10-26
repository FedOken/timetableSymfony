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
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\DayRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\Translation\TranslatorInterface;

class ScheduleController extends EasyAdminController
{
    protected $accessService;
    protected $universityRepo;
    protected $buildingRepo;
    protected $cabinetRepo;
    protected $partyRepo;
    protected $teacherRepo;
    protected $scheduleRepo;
    protected $universityTimeRepo;
    protected $weekRepo;
    protected $translator;

    public function __construct(TranslatorInterface $translator, WeekRepository $weekRepository, UniversityTimeRepository $universityTimeRepository, ScheduleRepository $scheduleRepository, TeacherRepository $teacherRepository, PartyRepository $partyRepository, AccessService $accessService, UniversityRepository $universityRepo, CabinetRepository $cabinetRepository, BuildingRepository $buildingRepository)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->buildingRepo = $buildingRepository;
        $this->universityRepo = $universityRepo;
        $this->cabinetRepo = $cabinetRepository;
        $this->partyRepo = $partyRepository;
        $this->teacherRepo = $teacherRepository;
        $this->scheduleRepo = $scheduleRepository;
        $this->universityTimeRepo = $universityTimeRepository;
        $this->weekRepo = $weekRepository;
        //Translator
        $this->translator = $translator;

    }

    /**
     * @param string $entityClass
     * @param string $sortDirection
     * @param null $sortField
     * @param null $dqlFilter
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
     * Action Edit, on update
     *
     * @param Schedule $entity
     */
    protected function updateEntity($entity)
    {
        $this->beforeSave($entity);
    }

    /**
     * Action New, on save
     *
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

        $universityModel = $this->universityRepo->find(ArrayHelper::getValue($request, 'university'));

        /**@var Schedule $entity*/
        $buildingValid = $this->buildingRepo->findBy( ['id' => $entity->cabinet->building->id, 'university' => $universityModel->id] );
        $cabinetValid = $this->cabinetRepo->findBy( ['id' => $entity->cabinet->id, 'building' => $entity->cabinet->building->id] );
        $partyValid = $this->partyRepo->findBy( ['id' => $entity->party->id, 'faculty' => ArrayHelper::getColumn($universityModel->faculties, 'id')] );
        $teacherValid = $this->teacherRepo->findBy( ['id' => $entity->teacher->id, 'university' => $universityModel->id] );
        $timeValid = $this->universityTimeRepo->findBy( ['id' => $entity->universityTime->id, 'university' => $universityModel->id] );

        if (!$buildingValid || !$cabinetValid || !$partyValid || !$teacherValid || !$timeValid) {
            $this->addFlash('warning', $this->translator->trans('validation_error'));
        }
        $this->addFlash('warning', $this->translator->trans('validation_error'));

        if($this->request->query->get('action') === 'new' && $scheduleModel = $this->scheduleRepo->findOneBy([
                'party' => $entity->party->id,
                'day' => $entity->day->id,
                'week' => $entity->week->id,
                'universityTime' => $entity->universityTime->id
            ]) ) {
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
        $universityToChoice = $this->getUniversities($entity);
        $teacherToChoice = $this->getTeachers($entity, $universityToChoice);
        $buildingsToChoice = $this->getBuilding($entity, $universityToChoice);
        $weekToChoice = $this->getWeeks($entity, $universityToChoice);
        $partyToChoice = $this->getParties($entity, $universityToChoice);
        $timeToChoice = $this->getTimes($entity, $universityToChoice);
        $cabinetToChoice = $this->getCabinets($entity, $buildingsToChoice);

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
            'attr' => ['data-widget' => 'select2']
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
            $this->addToForm($form, 'week', $this->weekRepo->findBy(['id' => $data['week']]),Week::class);
            $form->remove('universityTime');
            $this->addToForm($form, 'universityTime', $this->universityTimeRepo->findBy(['id' => $data['universityTime']]),UniversityTime::class);
        });

        return $formBuilder;
    }

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

    /**
     * @param object $entity
     * @return University[]
     */
    private function getUniversities($entity)
    {
        $currentUniversityId = ArrayHelper::getValue($entity, 'cabinet.building.university.id');
        $universityPermission = $this->accessService->getUniversityPermission($this->getUser());
        $universityModels = $this->universityRepo->getUniversityByUniversity($universityPermission);

        if ($currentUniversityId) {
            $currentModel = [];
            foreach ($universityModels as $key => $model) {
                if ($model->id === $currentUniversityId) {
                    $currentModel[] = $model;
                    unset($universityModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $universityModels);
        }

        return $universityModels;
    }

    /**
     * @param object $entity
     * @param University[] $universityModels
     * @return Building[]
     */
    private function getBuilding($entity, $universityModels)
    {
        $currentUniversityId = ArrayHelper::getValue($entity, 'cabinet.building.university.id');

        if ($currentUniversityId) {
            $currentBuildingId = ArrayHelper::getValue($entity, 'cabinet.building.id');
            $buildingModels = $this->buildingRepo->getBuildingsByUniversity([$currentUniversityId]);

            $currentModel = [];
            foreach ($buildingModels as $key => $model) {
                if ($model->id === $currentBuildingId) {
                    $currentModel[] = $model;
                    unset($buildingModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $buildingModels);

        } else {
            return $this->buildingRepo->getBuildingsByUniversity([ArrayHelper::getValue($universityModels,'0.id')]);
        }
    }

    /**
     * @param object $entity
     * @param Building[] $buildingModels
     * @return Cabinet[]
     */
    private function getCabinets($entity, $buildingModels)
    {
        $buildingId = ArrayHelper::getValue($buildingModels, '0.id');
        $cabinetModels = $this->cabinetRepo->getCabinetsByBuilding([$buildingId]);

        //Get data for existing entity
        if ($currentCabinetId = ArrayHelper::getValue($entity, 'cabinet.id')) {
            $currentModel = [];
            foreach ($cabinetModels as $key => $model) {
                if ($model->id === $currentCabinetId) {
                    $currentModel[] = $model;
                    unset($cabinetModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $cabinetModels);
        }

        //Get data for new entity
        if ($buildingId) {
            return $cabinetModels;
        }

        return [];
    }

    /**
     * @param object $entity
     * @param University[] $universityModels
     * @return Teacher[]
     */
    private function getTeachers($entity, $universityModels)
    {
        $universityId = ArrayHelper::getValue($universityModels, '0.id');
        $teacherModels = $this->teacherRepo->getTeachersByUniversity([$universityId]);

        //Get data for existing entity
        if ($currentTeacherId = ArrayHelper::getValue($entity, 'teacher.id')) {
            $currentModel = [];
            foreach ($teacherModels as $key => $model) {
                if ($model->id === $currentTeacherId) {
                    $currentModel[] = $model;
                    unset($teacherModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $teacherModels);
        }

        //Get data for new entity
        if ($universityId) {
            return $teacherModels;
        }

        return [];
    }

    /**
     * @param object $entity
     * @param University[] $universityModels
     * @return Week[]
     */
    private function getWeeks($entity, $universityModels)
    {
        $universityId = ArrayHelper::getValue($universityModels, '0.id');
        $weekModels = $this->weekRepo->getWeekByUniversity([$universityId]);

        //Get data for existing entity
        if ($currentWeekId = ArrayHelper::getValue($entity, 'week.id')) {
            $currentModel = [];
            foreach ($weekModels as $key => $model) {
                if ($model->id === $currentWeekId) {
                    $currentModel[] = $model;
                    unset($weekModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $weekModels);
        }

        //Get data for new entity
        if ($universityId) {
            return $weekModels;
        }

        return [];
    }

    /**
     * @param object $entity
     * @param University[] $universityModels
     * @return Party[]
     */
    private function getParties($entity, $universityModels)
    {
        $universityId = ArrayHelper::getValue($universityModels, '0.id');
        $partyModels = $this->partyRepo->getPartiesByUniversity([$universityId]);

        //Get data for existing entity
        if ($currentPartyId = ArrayHelper::getValue($entity, 'party.id')) {
            $currentModel = [];
            foreach ($partyModels as $key => $model) {
                if ($model->id === $currentPartyId) {
                    $currentModel[] = $model;
                    unset($partyModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $partyModels);
        }

        //Get data for new entity
        if ($universityId) {
            return $partyModels;
        }

        return [];
    }

    /**
     * @param object $entity
     * @param University[] $universityModels
     * @return Party[]
     */
    private function getTimes($entity, $universityModels)
    {
        $universityId = ArrayHelper::getValue($universityModels, '0.id');
        $timeModels = $this->universityTimeRepo->getTimesByUniversity([$universityId]);

        //Get data for existing entity
        if ($currentTimeId = ArrayHelper::getValue($entity, 'universityTime.id')) {
            $currentModel = [];
            foreach ($timeModels as $key => $model) {
                if ($model->id === $currentTimeId) {
                    $currentModel[] = $model;
                    unset($timeModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $timeModels);
        }

        //Get data for new entity
        if ($universityId) {
            return $timeModels;
        }

        return [];
    }



}