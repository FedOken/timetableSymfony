<?php

namespace App\Handler\for_entity;

use App\Entity\Schedule;
use App\Handler\BaseHandler;
use App\Helper\ArrayHelper;

class CabinetHandler
{
    /**
     * @param $weekId
     * @param $cabinetId
     * @param $dayId
     * @param $timeId
     * @return object[]|null
     */
    public function getScheduleByParams($weekId, $cabinetId, $dayId, $timeId)
    {
        $repoSch = $this->em->getRepository(Schedule::class);

        return $repoSch->findBy([
            'week' => $weekId,
            'cabinet' => $cabinetId,
            'day' => $dayId,
            'universityTime' => $timeId,
        ]);
    }

    /**
     * Custom serialize for teacher. One lesson can have few group.
     * @param array $schedules
     * @return array
     */
    public function serializeForSchedule(array $schedules): array
    {
        $partiesList = [];

        /** @var Schedule $schedule */
        foreach ($schedules as $schedule) {
            $partiesList[] = ArrayHelper::getValue($schedule, 'party.name');
        }

        $data = array_shift($schedules)->serialize();
        $data['party']['name'] = implode(', ', $partiesList);

        return $data;
    }
}