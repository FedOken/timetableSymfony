<?php

namespace App\Controller\EasyAdmin;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\TeacherPosition;
use App\Entity\University;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Controller\EasyAdmin\Handler\UniversityHandler;
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
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccess;
use App\Service\Access\TeacherAccess;
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

/**
 * Class TeacherPositionController
 * @package App\Controller\EasyAdmin
 *
 * @property array $validIds
 */
class TeacherPositionController extends AdminController
{
    private $validIds = [];

    private function init()
    {
        $this->validIds = ArrayHelper::getColumn($this->em->getRepository(TeacherPosition::class)->findAll(),'id');
    }

    protected function newAction()
    {
        $this->init();
        return $this->newCheckPermissionAndRedirect($this->validIds, 'TeacherPosition', [TeacherAccess::getAccessRole()]);
    }

    protected function listAction()
    {
        $this->init();
        return $this->listCheckPermissionAndRedirect($this->validIds, 'TeacherPosition', [TeacherAccess::getAccessRole()]);
    }

    protected function editAction()
    {
        $this->init();
        return $this->editCheckPermissionAndRedirect($this->validIds, 'TeacherPosition', [TeacherAccess::getAccessRole()]);
    }
}