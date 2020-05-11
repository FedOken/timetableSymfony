<?php

namespace App\Controller\ReactController;

use App\Entity\Party;
use App\Entity\University;
use App\Handler\schedule\ScheduleHandler;
use App\Helper\ArrayHelper;
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
        $data = $this->schHandler->formData($type, $week, $id);

        return new JsonResponse($data);
    }
}
