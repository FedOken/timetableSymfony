<?php

namespace App\Controller\ReactController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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
            return $data->serialize();
        }

        return new JsonResponse(null);
    }
}
