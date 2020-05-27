<?php

namespace App\Handler\for_entity;

use App\Entity\Schedule;
use App\Handler\BaseHandler;

class PartyHandler extends BaseHandler
{
    /**
     * @param $weekId
     * @param $partyId
     * @param $dayId
     * @param $timeId
     * @return object[]|null
     */
    public function getScheduleByParams($weekId, $partyId, $dayId, $timeId)
    {
        $repoSch = $this->em->getRepository(Schedule::class);

        return $repoSch->findBy([
            'week' => $weekId,
            'party' => $partyId,
            'day' => $dayId,
            'universityTime' => $timeId,
        ]);
    }


    /**
     * @param array $schedules
     * @return array
     */
    public function serializeForSchedule(array $schedules): array
    {
        $data = array_shift($schedules)->serialize();
        return $data;
    }
}