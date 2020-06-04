<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\ResetHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ResetPassword extends AbstractController
{
    private $handler;

    public function __construct(ResetHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/react/reset-password", name="react-resetPassword")
     */
    public function reactResetPassword()
    {
        $data = $this->handler->resetPassword();
        return new JsonResponse($data);
    }
}
