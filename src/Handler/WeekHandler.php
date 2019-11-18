<?php

namespace App\Handler;

use App\Entity\University;
use App\Entity\User;
use App\Repository\TeacherRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;

class WeekHandler
{
    protected $accessService;
    protected $weekRepo;

    public function __construct(AccessService $accessService, WeekRepository $weekRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->weekRepo = $weekRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param int|null $universityId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $universityId)
    {
        $entityModels = $this->weekRepo->getWeekByUniversity([$universityId]);

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

}