<?php

namespace App\Controller\ReactController;


use App\Controller\ReactController\Handler\PartyHandler;
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
        $data = $this->handler->getParties($unId);
        return new JsonResponse($data);
    }
}
