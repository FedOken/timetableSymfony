<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\DayRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Service\AccessService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validation;

class UniversityTimeController extends EasyAdminController
{
    protected $accessService;
    protected $universityRepo;
    protected $buildingRepo;
    protected $cabinetRepo;
    protected $partyRepo;
    protected $teacherRepo;
    protected $scheduleRepo;

    public function __construct(ScheduleRepository $scheduleRepository, TeacherRepository $teacherRepository, PartyRepository $partyRepository, AccessService $accessService, UniversityRepository $universityRepo, CabinetRepository $cabinetRepository, BuildingRepository $buildingRepository)
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
        $entity->setName();

        //Save entity
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();
        return true;
    }
}