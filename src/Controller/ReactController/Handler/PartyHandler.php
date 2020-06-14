<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\University;
use App\Repository\PartyRepository;
use App\Repository\UniversityRepository;

class PartyHandler extends BaseHandler
{
    /**
     * Return parties for selected university
     * @param int $unId
     * @return array
     */
    public function getParties(int $unId): array
    {
        try {
            /**@var PartyRepository $prtRepo */
            $prtRepo = $this->em->getRepository(Party::class);
            $prtModels = $prtRepo->findByUniversity($unId);

            $models = [];
            /**@var Party $model */
            foreach ($prtModels as $model) {
                $models[] = [
                    'id' => $model->id,
                    'unId' => $unId,
                    'facId' => $model->faculty->id,
                    'name' => $model->name,
                ];
            }
            return [
                'status' => true,
                'data' => $models,
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