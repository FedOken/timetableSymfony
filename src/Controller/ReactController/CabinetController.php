<?php

namespace App\Controller\ReactController;


use App\Controller\ReactController\Handler\CabinetHandler;
use App\Controller\ReactController\Handler\PartyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class CabinetController extends AbstractController
{
    private $handler;

    public function __construct(CabinetHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/cabinet/get-cabinets-by-building/{buildingId}", name="api-cabinet-getCabinetsByBuilding")
     * @param int $buildingId
     * @return JsonResponse
     */
    public function apiCabinetGetCabinetsByBuilding(int $buildingId)
    {
        $data = $this->handler->getCabinetsByBuilding($buildingId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/cabinet/get-cabinets-by-name/{name}", name="api-cabinet-getCabinetsByName")
     * @param string $name
     * @return JsonResponse
     */
    public function apiCabinetGetCabinetsByName($name)
    {
        $data = $this->handler->getCabinetsByName($name);
        return new JsonResponse($data);
    }
}
