<?php

namespace App\Handler;

use App\Entity\User;
use App\Repository\BuildingRepository;
use App\Service\AccessService;

class BuildingHandler
{
    protected $accessService;
    protected $buildingRepo;

    public function __construct(AccessService $accessService, BuildingRepository $buildingRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->buildingRepo = $buildingRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param int|null $universityId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $universityId)
    {
        $entityModels = $this->buildingRepo->getBuildingsByUniversity([$universityId]);

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

    public function checkEntityExist(int $id, int $universityId)
    {
        $model = $this->buildingRepo->findBy([
            'id' => $id,
            'university' => $universityId]
        );
        if ($model) {
            return true;
        }
        return false;
    }

}