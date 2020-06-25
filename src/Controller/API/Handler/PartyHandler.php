<?php

namespace App\Controller\API\Handler;

use App\Entity\Party;
use App\Repository\PartyRepository;

class PartyHandler extends BaseHandler
{
    /**
     * Return parties for selected university
     * @param int $unId
     * @return array
     */
    public function getPartiesByUniversity(int $unId): array
    {
        try {
            /**@var PartyRepository $repo */
            $repo = $this->em->getRepository(Party::class);
            $models = $repo->findByUniversities([$unId]);

            $data = [];
            /**@var Party $model */
            foreach ($models as $model) {
                $data[] = [
                    'id' => $model->id,
                    'unId' => $unId,
                    'facId' => $model->faculty->id,
                    'name' => $model->name,
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

    /**
     * Return autocomplete result
     * @param string $query
     * @return array
     */
    public function getPartiesByName(string $query): array
    {
        try {
            $query = trim($query);
            if (!$query) return [];

            /**@var PartyRepository $repo */
            $repo = $this->em->getRepository(Party::class);
            $models = $repo->findByName($query);

            $data = [];
            /**@var Party $model*/
            foreach ($models as $model) {
                $data[] = ['value' => $model->id, 'label' => $model->name];
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