<?php

namespace App\Handler;

use App\Entity\User;
use App\Repository\TeacherRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;

class UniversityTimeHandler
{
    protected $accessService;
    protected $universityTimeRepo;

    public function __construct(AccessService $accessService, UniversityTimeRepository $universityTimeRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->universityTimeRepo = $universityTimeRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param int|null $universityId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $universityId)
    {
        $entityModels = $this->universityTimeRepo->getTimesByUniversity([$universityId]);

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
        $model = $this->universityTimeRepo->findBy([
                'id' => $id,
                'university' => $universityId]
        );
        if ($model) {
            return true;
        }
        return false;
    }

}