<?php

namespace App\Handler;

use App\Entity\User;
use App\Repository\CabinetRepository;
use App\Repository\TeacherRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;

class CabinetHandler
{
    protected $accessService;
    protected $cabinetRepository;

    public function __construct(AccessService $accessService, CabinetRepository $cabinetRepository)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->cabinetRepository = $cabinetRepository;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param int|null $buildingId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $buildingId)
    {
        $entityModels = $this->cabinetRepository->getCabinetsByBuilding([$buildingId]);

        if ($currentId) {
            $currentModel = [];
            foreach ($entityModels as $key => $model) {
                if ($model->id === $currentId) {
                    $currentModel[] = $model;
                    unset($entityModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $entityModels);
        }

        return $entityModels;
    }

    public function checkEntityExist(int $id, int $buildingId)
    {
        $model = $this->cabinetRepository->findBy([
                'id' => $id,
                'building' => $buildingId]
        );
        if ($model) {
            return true;
        }
        return false;
    }

}