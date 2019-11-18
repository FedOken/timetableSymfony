<?php

namespace App\Handler;

use App\Entity\University;
use App\Entity\User;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\WeekRepository;
use App\Service\AccessService;

class PartyHandler
{
    protected $accessService;
    protected $partyRepo;

    public function __construct(AccessService $accessService, PartyRepository $partyRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->partyRepo = $partyRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param int|null $universityId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $universityId)
    {
        $entityModels = $this->partyRepo->getPartiesByUniversity([$universityId]);

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

    public function checkEntityExist(int $id, $facultyId)
    {
        $model = $this->partyRepo->findBy([
                'id' => $id,
                'faculty' => $facultyId]
        );
        if ($model) {
            return true;
        }
        return false;
    }

}