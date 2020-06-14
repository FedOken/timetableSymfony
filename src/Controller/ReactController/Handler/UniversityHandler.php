<?php

namespace App\Controller\ReactController\Handler;

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
            $unModels = $unRepo->findAll();

            $models = [];
            /**@var University $model */
            foreach ($unModels as $model) {
                $models[] = [
                    'id' => $model->id,
                    'name' => $model->name,
                    'name_full' => $model->name_full
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