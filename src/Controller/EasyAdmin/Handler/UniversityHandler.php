<?php

namespace App\Controller\EasyAdmin\Handler;

use App\Entity\University;
use App\Entity\User;

class UniversityHandler extends BaseHandler
{
    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $validIds = $this->access->getAccessObject($user)->getAccessibleUniversityIds();
        $entityModels = $this->em->getRepository(University::class)->findBy(['id' => $validIds, 'enable' => 1]);

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