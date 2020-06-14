<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\UniversityHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class UniversityController extends AbstractController
{
    private $handler;

    public function __construct(UniversityHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/university/get-universities", name="api-university-getUniversities")
     * @return JsonResponse
     */
    public function apiUniversityGetUniversities()
    {
        $data = $this->handler->getUniversities();
        return new JsonResponse($data);
    }
}
