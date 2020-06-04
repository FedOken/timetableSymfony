<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\RegisterHandler;

use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $handler;

    public function __construct(RegisterHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/react/register/create-party-user", name="react-register-createPartyUser")
     */
    public function reactRegisterCreatePartyUser()
    {
        $data = $this->handler->saveUser(PartyAccess::getAccessRole());
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/register/create-teacher-user", name="react-register-createTeacherUser")
     */
    public function reactRegisterCreateTeacherUser()
    {
        $data = $this->handler->saveUser(TeacherAccess::getAccessRole());
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/register/create-university-user", name="react-register-createUniversityUser")
     */
    public function reactRegisterCreateUniversityUser()
    {
        $data = $this->handler->saveUniversityUser();
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/register/confirm-email-send/{code}", name="react-register-confirmEmailSend")
     */
    public function reactRegisterConfirmEmailSend(string $code)
    {
        return new JsonResponse([$code]);
    }
}
