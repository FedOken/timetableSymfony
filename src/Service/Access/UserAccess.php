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

class UserAccess extends AccessService implements AccessInterface
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
    }

    public function getAccessiblePartyIds(): array
    {
        return [];
    }

    public function getAccessibleTeacherIds(): array
    {
        return [];
    }

    public function getAccessibleBuildingIds(): array
    {
        return [];
    }

    public function getAccessibleCabinetIds(array $bldngIds = []): array
    {
        return [];
    }

    public function getAccessibleCourseIds(): array
    {
        return [];
    }

    public function getAccessibleWeekIds(): array
    {
        return [];
    }

    public function getAccessibleTimeIds(): array
    {
        return [];
    }

    public function getAccessibleScheduleIds(): array
    {
        return [];
    }
}