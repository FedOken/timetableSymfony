<?php

namespace App\Controller\EasyAdmin\Handler;

use App\Entity\Building;
use App\Entity\Teacher;
use App\Entity\User;

class BuildingHandler extends BaseHandler
{
    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @param int $unId
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user, $unId = 0)
    {
        if ($unId) {
            $entityModels = $this->em->getRepository(Building::class)->findBy(['university' => $unId]);
        } else {
            $validIds = $this->access->getAccessObject($user)->getAccessibleBuildingIds();
            $entityModels = $this->em->getRepository(Building::class)->findBy(['id' => $validIds]);
        }

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
        $model = $this->em->getRepository(Building::class)->findBy([
            'id' => $id,
            'university' => $universityId]
        );
        return $model ? true : false;
    }

}