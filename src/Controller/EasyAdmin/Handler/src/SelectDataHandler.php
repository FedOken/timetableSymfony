<?php

namespace App\Controller\EasyAdmin\Handler\src;

use App\Controller\EasyAdmin\Handler\BaseHandler;
use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\University;
use App\Entity\UniversityTime;
use App\Entity\User;
use App\Entity\Week;
use App\Service\Access\AdminAccess;

class SelectDataHandler extends BaseHandler
{
    public function getDataTchr($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessibleTeacherIds();
        return $this->getDataToSelect2($currentId, Teacher::class, $allIds, ['name' => 'ASC']);
    }

    public function getDataUn($currentId): array
    {
        $allIds = $this->access->getAccessObject($this->user)->getAccessibleUniversityIds();
        return $this->getDataToSelect2($currentId, University::class, $allIds, ['name' => 'ASC']);
    }

    public function getDataFclt($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessibleFacultyIds();
        return $this->getDataToSelect2($currentId, Faculty::class, $allIds);
    }

    public function getDataBldng($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessibleBuildingIds();
        return $this->getDataToSelect2($currentId, Building::class, $allIds);
    }

    public function getDataPrt($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessiblePartyIds();
        return $this->getDataToSelect2($currentId, Party::class, $allIds, ['name' => 'ASC']);
    }

    public function getDataCrs($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessibleCourseIds();
        return $this->getDataToSelect2($currentId, Course::class, $allIds);
    }

    public function getDataWk($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessibleWeekIds();
        return $this->getDataToSelect2($currentId, Week::class, $allIds);
    }

    public function getDataUnTm($currentId, $unCurrent): array
    {
        $locUser = $this->getLocUser($unCurrent);
        $allIds = $this->access->getAccessObject($locUser)->getAccessibleTimeIds();
        return $this->getDataToSelect2($currentId, UniversityTime::class, $allIds);
    }

    public function getDataCbnt($currentId, $bldngId): array
    {
        $allIds = $this->access->getAccessObject($this->user)->getAccessibleCabinetIds([$bldngId]);
        return $this->getDataToSelect2($currentId, Cabinet::class, $allIds, ['name' => 'ASC']);
    }




    /** PRIVATE FUNCTIONS */

    private function getDataToSelect2($currentId, $className, array $allIds, $order = null): array
    {
        $allModels = $this->em->getRepository($className)->findBy(['id' => $allIds], $order);
        return $this->setModelToTopOfArray($currentId, $allModels);
    }

    private function setModelToTopOfArray($currentId, $allModels)
    {
        if ($currentId) {
            $currentModel = null;
            foreach ($allModels as $key => $model) {
                if ($model->id === $currentId) {
                    $currentModel = $model;
                    unset($allModels[$key]);
                    break;
                }
            }
            if ($currentModel) array_unshift($allModels, $currentModel);
            return $allModels;
        }
        return $allModels;
    }

    private function getLocUser(?int $unCurrent)
    {
        if ($this->user->roles[0] === AdminAccess::getAccessRole() && $unCurrent) {
            $locUser = $this->em->getRepository(User::class)->findOneBy(['university' => $unCurrent]);
        } else {
            $locUser = $this->user;
        }
        return $locUser;
    }
}