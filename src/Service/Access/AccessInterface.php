<?php

namespace App\Service\Access;

interface AccessInterface
{
    public function init($incomingCode);
    public static function getAccessCode();
    public static function getAccessRole();

    /** Return allowed university id */
    public function getAccessibleUniversityIds(): array;

    /** Return allowed faculty id */
    public function getAccessibleFacultyIds(): array;

    /** Return allowed party id */
    public function getAccessiblePartyIds(): array;

    /** Return allowed party id */
    public function getAccessibleTeacherIds(): array;

    /** Return allowed party id */
    public function getAccessibleBuildingIds(): array;

    /** Return allowed party id */
    /** @param int $buildingId */
    public function getAccessibleCabinetIds(array $bldngIds = []): array;

    /** Return allowed party id */
    public function getAccessibleCourseIds(): array;

    /** Return allowed party id */
    public function getAccessibleWeekIds(): array;

    /** Return allowed party id */
    public function getAccessibleTimeIds(): array;

    /** Return allowed party id */
    public function getAccessibleScheduleIds(): array;
}