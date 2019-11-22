<?php

namespace App\Handler;

use App\Entity\Party;
use App\Entity\User;

class PartyHandler extends BaseHandler
{
    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $validIds = $this->accessService->getAccessObject($user)->getAccessiblePartyIds();
        $entityModels = $this->em->getRepository(Party::class)->findBy(['id' => $validIds]);

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
        $model = $this->em->getRepository(Party::class)->findBy([
                'id' => $id,
                'faculty' => $facultyId]
        );
        return $model ? true : false;
    }

}