<?php

namespace App\Handler;

use App\Entity\User;
use App\Repository\CourseRepository;
use App\Service\AccessService;

class CourseHandler
{
    protected $accessService;
    protected $courseRepo;

    public function __construct(AccessService $accessService, CourseRepository $courseRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->courseRepo = $courseRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $universityPermission = $this->accessService->getUniversityPermission($user);
        $entityModels = $this->courseRepo->getCourseByUniversity($universityPermission);

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