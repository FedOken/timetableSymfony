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
use App\Repository\FacultyRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;

class AccessMiddleware extends AccessService
{
    public function getAccssFacIds($service): array
    {
        /** @var FacultyRepository $facRepo */
        $facRepo = $this->em->getRepository(Faculty::class);
        $facs = $facRepo->findByUniversities($service->getAccessibleUniversityIds());
        return $facs ? ArrayHelper::getColumn($facs, 'id') : [];
    }

    public function  getAccssPrtIds($service): array
    {
        /** @var PartyRepository $prtRepo */
        $prtRepo = $this->em->getRepository(Party::class);
        $prts = $prtRepo->findByFaculties($service->getAccessibleFacultyIds());
        return $prts ? ArrayHelper::getColumn($prts, 'id') : [];
    }

    public function getAccssTchrIds($service): array
    {
        /** @var TeacherRepository $tchrRepo */
        $tchrRepo = $this->em->getRepository(Teacher::class);
        $tchrs = $tchrRepo->findByUniversities($service->getAccessibleUniversityIds());
        return $tchrs ? ArrayHelper::getColumn($tchrs, 'id') : [];
    }

    public function getAccssBldngIds($service): array
    {
        /** @var BuildingRepository $bldngRepo */
        $bldngRepo = $this->em->getRepository(Building::class);
        $bldngs = $bldngRepo->findByUniversities($service->getAccessibleUniversityIds());
        return $bldngs ? ArrayHelper::getColumn($bldngs, 'id') : [];
    }

    public function getAccssCbntIds($service, array $bldngIds): array
    {
        /** @var CabinetRepository $cbntRepo */
        $cbntRepo = $this->em->getRepository(Cabinet::class);
        $cbnts = $cbntRepo->findByBuildings($bldngIds ?: $service->getAccessibleBuildingIds());
        return $cbnts ? ArrayHelper::getColumn($cbnts, 'id') : [];
    }

    public function getAccssCrsIds($service): array
    {
        /** @var CourseRepository $crsRepo */
        $crsRepo = $this->em->getRepository(Course::class);
        $crss = $crsRepo->findByUniversities($service->getAccessibleUniversityIds());
        return $crss ? ArrayHelper::getColumn($crss, 'id') : [];
    }

    public function getAccssWkIds($service): array
    {
        /** @var WeekRepository $wkRepo */
        $wkRepo = $this->em->getRepository(Week::class);
        $wks = $wkRepo->findByUniversities($service->getAccessibleUniversityIds());
        return $wks ? ArrayHelper::getColumn($wks, 'id') : [];
    }

    public function getAccssTmIds($service): array
    {
        /** @var UniversityTimeRepository $unTmRepo */
        $unTmRepo = $this->em->getRepository(UniversityTime::class);
        $unTms = $unTmRepo->findByUniversities($service->getAccessibleUniversityIds());
        return $unTms ? ArrayHelper::getColumn($unTms, 'id') : [];
    }
}