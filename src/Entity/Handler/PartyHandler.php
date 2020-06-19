<?php

namespace App\Entity\Handler;

use App\Entity\Party;

class PartyHandler
{
    private $model;

    public function __construct(Party $model)
    {
        $this->model = $model;
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
