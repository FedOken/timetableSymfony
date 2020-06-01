<?php

namespace App\Handler;

use App\Entity\Cabinet;
use App\Entity\User;

class CabinetHandler extends BaseHandler
{
    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @param int|null $buildingId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user, int $buildingId = null)
    {
        $validIds = $this->access->getAccessObject($user)->getAccessibleCabinetIds($buildingId);
        $entityModels = $this->em->getRepository(Cabinet::class)->findBy(['id' => $validIds]);

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
        $model = $this->em->getRepository(Cabinet::class)->findBy([
                'id' => $id,
                'building' => $buildingId]
        );
        return $model ? true : false;
    }

}