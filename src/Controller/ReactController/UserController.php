<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    private $handler;

    public function __construct(UserHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/user/get-user", name="api-user-getUser")
     * @return JsonResponse
     */
    public function apiUserGetUser()
    {
        $data = $this->handler->getUserData();
        return new JsonResponse($data);
    }
}
