<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\ProfileHandler;
use App\Service\Access\PartyAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private $handler;

    public function __construct(ProfileHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/react/profile/get-user-data/{userId}", name="react-profile-getUserData")
     */
    public function reactProfileGetUserData($userId)
    {
        $data = $this->handler->getUserData($userId);
        return new JsonResponse($data);
    }
}
