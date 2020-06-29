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
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;

/**
 * Class UniversityAccess
 * @package App\Service\Access
 *
 * @property string $code
 * @property University $accessModel
 */

class UniversityAccess extends AccessMiddleware implements AccessInterface
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
        return 'U';
    }

    public static function getAccessRole()
    {
        return 'ROLE_UNIVERSITY_MANAGER';
    }

    public function getAccessibleUniversityIds(): array
    {
        return [$this->accessModel->id];
    }

    public function getAccessibleFacultyIds(): array
    {
        return $this->getAccssFacIds($this);
    }

    public function getAccessiblePartyIds(): array
    {
        return $this->getAccssPrtIds($this);
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
        $schs = $schRepo->findBy(['party' => $this->getAccessiblePartyIds()]);
        return $schs ? ArrayHelper::getColumn($schs, 'id') : [];
    }


    //
    /* PRIVATE FUNCTION */
    //
    private function getAccessModel(int $id)
    {
        return $this->em->getRepository(University::class)->findOneBy(['id' => $id]);
    }
}