<?php

namespace App\Entity\Handler;

use App\Entity\Cabinet;
use App\Entity\Schedule;
use App\Helper\ArrayHelper;

class CabinetHandler
{
    private $model;

    public function __construct(Cabinet $model)
    {
        $this->model = $model;
    }

    /**
     * Custom serialize for cabinet. One cabinet can have few parties.
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
