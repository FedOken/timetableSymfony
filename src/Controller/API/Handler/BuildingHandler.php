<?php

namespace App\Controller\API\Handler;

use App\Entity\Building;
use App\Repository\BuildingRepository;

class BuildingHandler extends BaseHandler
{
    /**
     * Return teachers for selected university
     * @param int $unId
     * @return array
     */
    public function getBuildingsByUniversity(int $unId): array
    {
        try {
            /**@var BuildingRepository $repo */
            $repo = $this->em->getRepository(Building::class);
            $models = $repo->findByUniversities([$unId]);

            $data = [];
            /**@var Building $model */
            foreach ($models as $model) {
                $data[] = [
                    'id' => $model->id,
                    'unId' => $unId,
                    'name' => $model->name,
                    'nameFull' => $model->name_full,
                    'address' => $model->address,
                ];
            }
            return [
                'status' => true,
                'data' => $data,
                'unId' => $unId
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}