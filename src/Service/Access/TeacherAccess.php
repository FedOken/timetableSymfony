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
use App\Repository\FacultyRepository;
use App\Repository\PartyRepository;
use App\Repository\ScheduleRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;

/**
 * Class TeacherAccess
 * @package App\Service\Access
 *
 * @property string $code
 * @property Teacher $accessModel
 */
class TeacherAccess extends AccessMiddleware implements AccessInterface
{
    public $code;
    public $accessModel;

    public function init($incomingCode)
    {
        $this->code = $incomingCode;
        $this->accessModel = $this->getAccessModel($incomingCode);
    }

    public static function getAccessCode()
    {
        return 'T';
    }

    public static function getAccessRole()
    {
        return 'ROLE_TEACHER';
    }

    public function getAccessibleUniversityIds(): array
    {
        return [$this->accessModel->university->id];
    }

    public function getAccessibleFacultyIds(array $unIds = []): array
    {
        $facs = $this->accessModel->university->faculties;
        return $facs ? ArrayHelper::getColumn($facs, 'id') : [];
    }

    public function getAccessiblePartyIds(): array
    {
        return $this->getAccssPrtIds($this);
    }

    public function getAccessibleTeacherIds(): array
    {
        return [$this->accessModel->id];
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
        $schs = $schRepo->findBy(['teacher' => $this->accessModel->id]);
        return $schs ? ArrayHelper::getColumn($schs, 'id') : [];
    }




    //
    /* PRIVATE FUNCTION */
    //
    private function getAccessModel(int $id)
    {
        return $this->em->getRepository(Teacher::class)->findOneBy(['id' => $id]);
    }
}