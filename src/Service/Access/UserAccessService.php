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

class UserAccessService extends AccessService implements AccessInterface
{
    public $code;

    public function init($incomingCode)
    {
        $this->code = $incomingCode;
    }

    public static function getAccessCode()
    {
        return 'User';
    }

    public static function getAccessRole()
    {
        return 'ROLE_USER';
    }

    public function getAccessibleUniversityIds(): array
    {
        return [$this->code];
    }

    public function getAccessibleFacultyIds(): array
    {
        return [];
//        $accessModel = $this->em->getRepository(University::class)->findOneBy(['id' => $this->code]);
//        /** @var University $accessModel */
//        $response = $accessModel->faculties;
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessiblePartyIds(): array
    {
        return [];
//        $response = $this->em->getRepository(Party::class)->getByUniversity([$this->code]);
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTeacherIds(): array
    {
        return [];
//        $accessModel = $this->em->getRepository(University::class)->findOneBy(['id' => $this->code]);
//        /** @var University $accessModel */
//        $response = $accessModel->teachers;
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleBuildingIds(): array
    {
        return [];
//        $accessModel = $this->em->getRepository(University::class)->findOneBy(['id' => $this->code]);
//        /** @var University $accessModel */
//        $response = $accessModel->buildings;
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCabinetIds(int $buildingId = null): array
    {
        return [];
//        $response = $this->em->getRepository(Cabinet::class)->getByUniversity([$this->code]);
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCourseIds(): array
    {
        return [];
//        $accessModel = $this->em->getRepository(University::class)->findOneBy(['id' => $this->code]);
//        /** @var University $accessModel */
//        $response = $accessModel->courses;
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleWeekIds(): array
    {
        return [];
//        $accessModel = $this->em->getRepository(University::class)->findOneBy(['id' => $this->code]);
//        /** @var University $accessModel */
//        $response = $accessModel->weeks;
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTimeIds(): array
    {
        return [];
//        $accessModel = $this->em->getRepository(University::class)->findOneBy(['id' => $this->code]);
//        /** @var University $accessModel */
//        $response = $accessModel->universityTimes;
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleScheduleIds(): array
    {
        return [];
//        $response = $this->em->getRepository(Schedule::class)->getByUniversity($this->code);
//        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }
}