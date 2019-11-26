<?php

namespace App\Handler;

use App\Entity\University;
use App\Entity\UniversityTime;
use App\Entity\User;
use App\Entity\Week;
use App\Repository\TeacherRepository;
use App\Repository\WeekRepository;
use App\Service\Access\AccessService;

class WeekHandler extends BaseHandler
{
    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $validIds = $this->accessService->getAccessObject($user)->getAccessibleWeekIds();
        $entityModels = $this->em->getRepository(Week::class)->findBy(['id' => $validIds]);

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