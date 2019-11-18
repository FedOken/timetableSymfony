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
use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\DayRepository;
use App\Repository\LessonTypeRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherPositionRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\Translation\TranslatorInterface;

class TeacherPositionController extends AdminController
{
    private $teacherPosition;

    public function __construct(TeacherPositionRepository $teacherPositionRepository, TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        parent::__construct($translator, $universityHandler, $accessService);

        $this->teacherPosition = $teacherPositionRepository;
    }

    /**
     * List action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listAction()
    {
        $validIds = ArrayHelper::getColumn($this->teacherPosition->findAll(),'id');
        return $this->listCheckPermissionAndRedirect($validIds, 'TeacherPosition', AccessService::ROLE_ADMIN);
    }

    /**
     * Edit action override
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editAction()
    {
        $validIds = ArrayHelper::getColumn($this->teacherPosition->findAll(),'id');
        return $this->editCheckPermissionAndRedirect($validIds, 'TeacherPosition', AccessService::ROLE_ADMIN);
    }
}