<?php

namespace App\Handler;

use App\Entity\University;
use App\Entity\User;
use App\Repository\TeacherRepository;
use App\Service\AccessService;

class TeacherHandler
{
    protected $accessService;
    protected $teacherRepo;

    public function __construct(AccessService $accessService, TeacherRepository $teacherRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->teacherRepo = $teacherRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param int|null $universityId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $universityId)
    {
        $entityModels = $this->teacherRepo->getTeachersByUniversity([$universityId]);

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
        $model = $this->teacherRepo->findBy([
                'id' => $id,
                'university' => $universityId]
        );
        if ($model) {
            return true;
        }
        return false;
    }

}