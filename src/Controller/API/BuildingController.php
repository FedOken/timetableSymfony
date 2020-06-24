<?php

namespace App\Controller\API;


use App\Controller\API\Handler\BuildingHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class BuildingController extends AbstractController
{
    private $handler;

    public function __construct(BuildingHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/building/get-buildings-by-university/{unId}", name="api-building-getBuildingsByUniversity")
     * @param int $unId
     * @return JsonResponse
     */
    public function apiBuildingGetBuildingsByUniversity(int $unId)
    {
        $data = $this->handler->getBuildingsByUniversity($unId);
        return new JsonResponse($data);
    }
}
