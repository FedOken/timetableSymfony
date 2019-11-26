<?php

namespace App\Handler;

use App\Entity\UniversityTime;
use App\Entity\User;
use App\Repository\TeacherRepository;
use App\Repository\UniversityTimeRepository;
use App\Repository\WeekRepository;
use App\Service\Access\AccessService;

class UniversityTimeHandler extends BaseHandler
{
    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $validIds = $this->accessService->getAccessObject($user)->getAccessibleTimeIds();
        $entityModels = $this->em->getRepository(UniversityTime::class)->findBy(['id' => $validIds]);

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
        $model = $this->em->getRepository(UniversityTime::class)->findBy([
                'id' => $id,
                'university' => $universityId]
        );
        return $model ? true : false;
    }

}