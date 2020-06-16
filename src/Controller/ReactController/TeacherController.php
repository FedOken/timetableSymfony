<?php

namespace App\Controller\ReactController;


use App\Controller\ReactController\Handler\PartyHandler;
use App\Controller\ReactController\Handler\TeacherHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class TeacherController extends AbstractController
{
    private $handler;

    public function __construct(TeacherHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/teacher/get-teachers-by-university/{unId}", name="api-teacher-getTeachersByUniversity")
     * @param int $unId
     * @return JsonResponse
     */
    public function apiTeacherGetTeachersByUniversity(int $unId)
    {
        $data = $this->handler->getTeachersByUniversity($unId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/teacher/get-teachers-by-name/{name}", name="api-teacher-getTeacherByName")
     * @param string $name
     * @return JsonResponse
     */
    public function apiTeacherGetTeachersByName($name)
    {
        $data = $this->handler->getTeachersByName($name);
        return new JsonResponse($data);
    }
}
