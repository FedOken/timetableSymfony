<?php

namespace App\Controller\EasyAdmin\Handler;

use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\Week;

class TeacherHandler extends BaseHandler
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
            $entityModels = $this->em->getRepository(Teacher::class)->findBy(['university' => $unId]);
        } else {
            $validIds = $this->access->getAccessObject($user)->getAccessibleTeacherIds();
            $entityModels = $this->em->getRepository(Teacher::class)->findBy(['id' => $validIds]);
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
        $model = $this->em->getRepository(Teacher::class)->findBy([
                'id' => $id,
                'university' => $universityId]
        );
        return $model ? true : false;
    }

}