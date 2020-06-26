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
use App\Repository\CabinetRepository;

class AdminAccess extends AccessService implements AccessInterface
{
    public $code;

    public function init($incomingCode)
    {
        $this->code = $incomingCode;
    }

    public static function getAccessCode()
    {
        return 'A';
    }

    public static function getAccessRole()
    {
        return 'ROLE_ADMIN';
    }

    public function getAccessibleUniversityIds(): array
    {
        $response = $this->em->getRepository(University::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleFacultyIds(): array
    {
        $response = $this->em->getRepository(Faculty::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessiblePartyIds(): array
    {
        $response = $this->em->getRepository(Party::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }


    public function getAccessibleTeacherIds(): array
    {
        $response = $this->em->getRepository(Teacher::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleBuildingIds(): array
    {
        $response = $this->em->getRepository(Building::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCabinetIds(int $buildingId = null): array
    {
        /** @var CabinetRepository $repo */
        $repo = $this->em->getRepository(Cabinet::class);
        if ($buildingId) $response = $repo->findByBuildings([$buildingId]);
        else $response = $repo->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCourseIds(): array
    {
        $response = $this->em->getRepository(Course::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleWeekIds(): array
    {
        $response = $this->em->getRepository(Week::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTimeIds(): array
    {
        $response = $this->em->getRepository(UniversityTime::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleScheduleIds(): array
    {
        $response = $this->em->getRepository(Schedule::class)->findAll();
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }
}