<?php

namespace App\Controller\API\Handler;

use App\Entity\University;
use App\Repository\UniversityRepository;

class UniversityHandler extends BaseHandler
{
    /**
     * Return all universities
     * @return array
     */
    public function getUniversities(): array
    {
        try {
            /**@var UniversityRepository $unRepo */
            $unRepo = $this->em->getRepository(University::class);
            $unModels = $unRepo->findBy(['enable' => 1]);

            $models = [];
            foreach ($unModels as $model) {
                $models[] = [
                    'id' => $model->id,
                    'name' => $model->name,
                    'nameFull' => $model->name_full
                ];
            }
            return [
                'status' => true,
                'data' => $models
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}