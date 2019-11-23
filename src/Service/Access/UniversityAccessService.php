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

/**
 * Class UniversityAccessService
 *
 * @property University $accessModel
 *
 * @package App\Service\Access
 */

class UniversityAccessService extends AccessService implements AccessInterface
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
        return [$this->code];
    }

    public function getAccessibleFacultyIds(): array
    {
        $response = $this->accessModel->faculties;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessiblePartyIds(): array
    {
        $facultyModels = $this->accessModel->faculties;
        $response = [];
        foreach ($facultyModels as $faculty) {
            $response = array_merge($response, $faculty->parties);
        }
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTeacherIds(): array
    {
        $response = $this->accessModel->teachers;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleBuildingIds(): array
    {
        $response = $this->accessModel->buildings;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCabinetIds(): array
    {
        $buildingModels = $this->accessModel->buildings;
        $response = [];
        foreach ($buildingModels as $building) {
            $response = array_merge($response, $building->cabinets);
        }
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCourseIds(): array
    {
        $response = $this->accessModel->courses;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleWeekIds(): array
    {
        $response = $this->accessModel->weeks;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTimeIds(): array
    {
        $response = $this->accessModel->universityTimes;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleScheduleIds(): array
    {
        $facultyModels = $this->accessModel->faculties;
        $partyModels = [];
        foreach ($facultyModels as $faculty) {
            $partyModels = array_merge($partyModels, $faculty->parties);
        }
        /** @var Party $party*/
        $response = [];
        foreach ($partyModels as $party) {
            $response = array_merge($response, $party->schedules);
        }
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }


    //
    /* PRIVATE FUNCTION */
    //
    private function getAccessModel(int $id)
    {
        return $this->em->getRepository(University::class)->findOneBy(['id' => $id]);
    }
}