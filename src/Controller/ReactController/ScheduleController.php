<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\ScheduleHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    private $handler;

    public function __construct(ScheduleHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/react/schedule/get-data/{type}/{week}/{id}", name="react-schedule-getData")
     * @return JsonResponse
     */
    public function reactScheduleGetData(string $type, int $week, int $id)
    {
        $data = $this->handler->formSchedule($type, $week, $id);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/schedule/get-weeks/{type}/{id}", name="react-schedule-getWeeks")
     * @param string $type
     * @param int $id
     * @return JsonResponse
     */
    public function reactScheduleGetWeeks($type, $id)
    {
        try {
            $data = $this->handler->formWeeks($type, $id);
        } catch (\Exception $e) {
            $data = [];
        }
        return new JsonResponse($data);
    }
}
