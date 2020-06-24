<?php

namespace App\Controller\API;


use App\Controller\API\Handler\ContactHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    private $handler;

    public function __construct(ContactHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/api/contact/send-contact-letter", name="api-contact-sendContactLetter")
     * @return JsonResponse
     */
    public function apiContactSendContactLetter()
    {
        $data = $this->handler->sendContactLetter();
        return new JsonResponse($data);
    }
}
