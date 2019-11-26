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
 * Class FacultyAccessService
 *
 * @property Party $accessModel
 * @property Faculty $parentModel
 *
 * @package App\Service\Access
 */

class PartyAccessService extends AccessService implements AccessInterface
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
        return 'P';
    }

    public static function getAccessRole()
    {
        return 'ROLE_PARTY_MANAGER';
    }

    public function getAccessibleUniversityIds(): array
    {
        $response = $this->parentModel->university;
        return $response ? [ArrayHelper::getValue($response, 'id')] : [];
    }

    public function getAccessibleFacultyIds(): array
    {
        $response = $this->parentModel;
        return $response ? [ArrayHelper::getValue($response, 'id')] : [];
    }

    public function getAccessiblePartyIds(): array
    {
        return [$this->code];
    }

    public function getAccessibleTeacherIds(): array
    {
        $response = ArrayHelper::getValue($this->parentModel, 'university.teachers');
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleBuildingIds(): array
    {
        $response = ArrayHelper::getValue($this->parentModel, 'university.buildings');
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCabinetIds(int $buildingId = null): array
    {
        if ($buildingId) {
            $response = $this->em->getRepository(Cabinet::class)->findBy(['building' => $buildingId]);
        } else {
            $buildingModels = ArrayHelper::getValue($this->parentModel, 'university.buildings');
            $response = [];
            foreach ($buildingModels as $building) {
                $response = array_merge($response, $building->cabinets);
            }
        }
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleCourseIds(): array
    {
        $response = ArrayHelper::getValue($this->parentModel, 'university.courses');
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleWeekIds(): array
    {
        $response = ArrayHelper::getValue($this->parentModel, 'university.weeks');
        return $response ? ArrayHelper::getColumn($response, 'id') : [];
    }

    public function getAccessibleTimeIds(): array
    {
        $response = ArrayHelper::getValue($this->parentModel, 'university.universityTimes');
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
        return $this->em->getRepository(Party::class)->findOneBy(['id' => $id]);
    }
    private function getParentModel()
    {
        return $this->accessModel->faculty;
    }
}