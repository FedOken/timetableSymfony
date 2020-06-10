<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\LayoutHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LayoutController extends AbstractController
{
    private $handler;

    public function __construct(LayoutHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/react/layout/get-user", name="react-layout-getUser")
     * @return JsonResponse
     */
    public function reactLayoutGetUser()
    {
        $data = $this->handler->getUserData();
        return new JsonResponse($data);
    }
}
