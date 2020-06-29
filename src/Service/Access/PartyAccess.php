<?php

namespace App\Service\Access;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Helper\ArrayHelper;
use App\Repository\BuildingRepository;
use App\Repository\CabinetRepository;
use App\Repository\CourseRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;

/**
 * Class FacultyAccess
 * @package App\Service\Access
 *
 * @property string $code
 * @property Party $accessModel
 */
class PartyAccess extends AccessMiddleware implements AccessInterface
{
    private $code;
    public $accessModel;

    public function init($incomingCode)
    {
        $this->code = $incomingCode;
        $this->accessModel = $this->getAccessModel($incomingCode);
    }

    public static function getAccessCode()
    {
        return 'P';
    }

    public static function getAccessRole()
    {
        return 'ROLE_PARTY_MANAGER';
    }

    public function getAccessibleUniversityIds(): array
    {
        return [$this->accessModel->faculty->university->id];
    }

    public function getAccessibleFacultyIds(array $unIds = []): array
    {
        return [$this->accessModel->faculty->id];
    }

    public function getAccessiblePartyIds(array $unIds = []): array
    {
        return [$this->accessModel->id];
    }

    public function getAccessibleTeacherIds(): array
    {
        return $this->getAccssTchrIds($this);
    }

    public function getAccessibleBuildingIds(): array
    {
        return $this->getAccssBldngIds($this);
    }

    public function getAccessibleCabinetIds(array $bldngIds = []): array
    {
        return $this->getAccssCbntIds($this, $bldngIds);
    }

    public function getAccessibleCourseIds(): array
    {
        return $this->getAccssCrsIds($this);
    }

    public function getAccessibleWeekIds(): array
    {
        return $this->getAccssWkIds($this);
    }

    public function getAccessibleTimeIds(): array
    {
        return $this->getAccssTmIds($this);
    }

    public function getAccessibleScheduleIds(): array
    {
        /** @var ScheduleRepository $facRepo */
        $schRepo = $this->em->getRepository(Schedule::class);
        $schs = $schRepo->findBy(['party' => $this->accessModel->id]);
        return $schs ? ArrayHelper::getColumn($schs, 'id') : [];
    }


    //
    /* PRIVATE FUNCTION */
    //
    private function getAccessModel(int $id)
    {
        return $this->em->getRepository(Party::class)->findOneBy(['id' => $id]);
    }
}