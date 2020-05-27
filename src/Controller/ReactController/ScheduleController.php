<?php

namespace App\Controller\ReactController;

use App\Handler\for_controller\react\ScheduleHandler;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ScheduleController extends AbstractController
{
    private $schHandler;
    public function __construct(ScheduleHandler $schHandler)
    {
        $this->schHandler = $schHandler;
    }

    /**
     * @Route("/react/schedule/get-data/{type}/{week}/{id}", name="react-schedule-getData")
     * @return JsonResponse
     */
    public function reactScheduleGetData(string $type, int $week, int $id)
    {
        $data = $this->schHandler->formSchedule($type, $week, $id);
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
            $data = $this->schHandler->formWeeks($type, $id);
        } catch (\Exception $e) {
            $data = [];
        }
        return new JsonResponse($data);
    }
}
