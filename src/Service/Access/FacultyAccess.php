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
 * Class FacultyAccess
 *
 * @property Faculty $accessModel
 * @property University $parentModel
 *
 * @package App\Service\Access
 */

class FacultyAccess extends AccessService implements AccessInterface
{
    private $code;
    public $accessModel;
    private $parentModel;

    public function init($incomingCode)
    {
        $this->code = $incomingCode;
        $this->accessModel = $this->getAccessModel($incomingCode);
        $this->parentModel = $this->getParentModel();
    }

    public static function getAccessCode()
    {
        return 'F';
    }

    public static function getAccessRole()
    {
        return 'ROLE_FACULTY_MANAGER';
    }

    public function getAccessibleUniversityIds(): array
    {
        $response = $this->accessModel->university;
        return $response ? [ArrayHelper::getValue($response, 'id')] : [];
    }

    public function getAccessibleFacultyIds(): array
    {
        return [$this->code];
    }

    public function getAccessiblePartyIds(): array
    {
        $response = $this->accessModel->parties;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTeacherIds(): array
    {
        $response = $this->parentModel->teachers;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleBuildingIds(): array
    {
        $response = $this->parentModel->buildings;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCabinetIds(int $buildingId = null): array
    {
        if ($buildingId) {
            $response = $this->em->getRepository(Cabinet::class)->findBy(['building' => $buildingId]);
        } else {
            $buildingModels = ArrayHelper::getValue($this->parentModel, 'buildings');
            $response = [];
            foreach ($buildingModels as $building) {
                $response = array_merge($response, $building->cabinets);
            }
        }
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCourseIds(): array
    {
        $response = $this->parentModel->courses;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleWeekIds(): array
    {
        $response = $this->parentModel->weeks;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTimeIds(): array
    {
        $response = $this->parentModel->universityTimes;
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleScheduleIds(): array
    {
        $response = $this->em->getRepository(Schedule::class)->findBy(['party' => $this->getAccessiblePartyIds()]);
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }


    //
    /* PRIVATE FUNCTION */
    //
    private function getAccessModel(int $id)
    {
        return $this->em->getRepository(Faculty::class)->findOneBy(['id' => $id]);
    }
    private function getParentModel()
    {
        return $this->accessModel->university;
    }
}