<?php

namespace App\Controller\API;


use App\Controller\API\Handler\PartyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class PartyController extends AbstractController
{
    private $handler;

    public function __construct(PartyHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/party/get-parties-by-university/{unId}", name="api-party-getPartiesByUniversity")
     * @param int $unId
     * @return JsonResponse
     */
    public function apiPartiesGetPartiesByUniversity(int $unId)
    {
        $data = $this->handler->getPartiesByUniversity($unId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/party/get-parties-by-name/{name}", name="api-party-getPartiesByName")
     * @param string $name
     * @return JsonResponse
     */
    public function apiPartiesGetPartiesByName($name)
    {
        $data = $this->handler->getPartiesByName($name);
        return new JsonResponse($data);
    }
}
