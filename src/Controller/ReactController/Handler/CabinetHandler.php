<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Cabinet;
use App\Repository\CabinetRepository;

class CabinetHandler extends BaseHandler
{
    /**
     * Return cabinets for selected building
     * @param int $buildingId
     * @return array
     */
    public function getCabinetsByBuilding(int $buildingId): array
    {
        try {
            /**@var CabinetRepository $repo */
            $repo = $this->em->getRepository(Cabinet::class);
            $models = $repo->findBy(['building' => $buildingId]);

            $data = [];
            /**@var Cabinet $model */
            foreach ($models as $model) {
                $data[] = [
                    'id' => $model->id,
                    'buildingId' => $buildingId,
                    'name' => $model->name,
                ];
            }
            return [
                'status' => true,
                'data' => $data,
                'buildingId' => $buildingId
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}