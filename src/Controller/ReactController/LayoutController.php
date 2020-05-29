<?php

namespace App\Controller\ReactController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LayoutController extends AbstractController
{
    /**
     * @Route("/react/layout/get-user", name="react-layout-getUser")
     * @return JsonResponse
     */
    public function reactLayoutGetUser()
    {
        $response = $this->getUser() ? $this->getUser()->serialize() : [];
        return new JsonResponse($response);
    }
}
