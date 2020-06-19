<?php

namespace App\Entity\Handler;

use App\Entity\Cabinet;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Helper\ArrayHelper;

class TeacherHandler
{
    private $model;

    public function __construct(Teacher $model)
    {
        $this->model = $model;
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
