<?php

namespace App\Controller\ReactController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
    /**
     * @Route("/react/content/get-login-status", name="react-content-getLoginStatus")
     *
     * @return JsonResponse
     */
    public function reactContentGetLoginStatus()
    {
        $data = $this->getUser();

        if ($data) {
            $data = $data->serialize();
        } else {
            $data = null;
        }

        return new JsonResponse($data);
    }
}
