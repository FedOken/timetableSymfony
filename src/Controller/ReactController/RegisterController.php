<?php

namespace App\Controller\ReactController;

use App\Entity\Party;
use App\Entity\University;
use App\Entity\User;
use App\Handler\for_controller\react\RegisterHandler;
use App\Handler\for_controller\react\SearchHandler;
use App\Helper\ArrayHelper;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
    public function reactRegisterCreatePartyUser(Request $request)
    {
        $data = $this->handler->saveUser($request, PartyAccess::getAccessRole());
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/register/create-teacher-user", name="react-register-createTeacherUser")
     */
    public function reactRegisterCreateTeacherUser(Request $request)
    {
        $data = $this->handler->saveUser($request, TeacherAccess::getAccessRole());
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/register/create-university-user", name="react-register-createUniversityUser")
     */
    public function reactRegisterCreateUniversityUser(Request $request)
    {
        $data = $this->handler->saveUser($request, UniversityAccess::getAccessRole());
        return new JsonResponse($data);
    }
}
