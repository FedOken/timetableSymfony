<?php

namespace App\Controller\API\Handler;

use App\Entity\Cabinet;
use App\Entity\Party;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;

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
            $models = $repo->findByBuildings([$buildingId]);

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

    /**
     * Return autocomplete result
     * @param string $query
     * @return array
     */
    public function getCabinetsByName(string $query): array
    {
        try {
            $query = trim($query);
            if (!$query) return [];

            /**@var CabinetRepository $repo */
            $repo = $this->em->getRepository(Cabinet::class);
            $models = $repo->findByName($query);

            $data = [];
            /**@var Cabinet $model*/
            foreach ($models as $model) {
                $building = $model->building;
                $name = "{$model->name} - {$building->name} - {$building->university->name}";
                $data[] = ['value' => $model->id, 'label' => $name];
            }
            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}