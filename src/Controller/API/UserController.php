<?php

namespace App\Controller\API;

use App\Controller\API\Handler\UserHandler;
use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/api/user/get-csrf-token", name="api-user-getCsrfToken")
     * @return JsonResponse
     */
    public function apiUserGetCsrfToken()
    {
        try {
            $token = $this->container->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
            $data = [
                'status' => true,
                'data' => $token
            ];
        } catch (Exception $e) {
            $data = [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
        return new JsonResponse($data);
    }


    /**
     * Entry point for log-in
     * @Route("/api/user/login-start", name="api-user-loginStart")
     */
    public function apiUserLoginStart()
    {
        //throw new \Exception('This method can be blank - it will be intercepted by the login key on your firewall');
        return new JsonResponse([]);
    }

    /**
     * End point for log-in
     * @Route("/api/user/login-end", name="api-user-loginEnd")
     */
    public function apiUserLoginEnd(Request $request)
    {
        $response = [
            'status' => $request->getSession()->get(LoginFormAuthenticator::LOGIN_STATUS),
            'errorCode' => $request->getSession()->get(LoginFormAuthenticator::REASON_CODE),
            'error' => $request->getSession()->get(LoginFormAuthenticator::REASON),
            'code' => $request->getSession()->get(LoginFormAuthenticator::USER_CODE),
            'user' => $this->getUser() ? $this->getUser()->handler->serialize() : null,
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/user/logout-start", name="api-user-logoutStart")
     * @return JsonResponse
     */
    public function apiUserLogoutStart()
    {
        //throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
        return new JsonResponse([]);
    }

    /**
     * @Route("/api/user/logout-end", name="api-user-logoutEnd", schemes={"https"})
     */
    public function apiUserLogoutEnd()
    {
        return $this->redirect('/login');
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

    /**
     * @Route("/api/user/get-relation", name="api-user-getRelation")
     * @return JsonResponse
     */
    public function apiUserGetRelation()
    {
        $data = $this->handler->getUserRelation();
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/update-model", name="api-user-updateModel")
     * @return JsonResponse
     */
    public function apiUserUpdateModel()
    {
        $data = $this->handler->updateModel();
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/update-password", name="api-user-updatePassword")
     * @return JsonResponse
     */
    public function apiUserUpdatePassword()
    {
        $data = $this->handler->updatePassword();
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/confirm-email-send/{code}", name="api-user-confirmEmailSend")
     * @param string $code
     * @return JsonResponse
     */
    public function apiUserConfirmEmailSend(string $code)
    {
        $data = $this->handler->sendConfirmEmailStep1($code);
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/confirm-email", name="api-user-confirmEmail")
     */
    public function apiUserConfirmEmail()
    {
        $data = $this->handler->emailConfirmation();
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/create-party-user", name="api-user-createPartyUser")
     */
    public function apiUserCreatePartyUser()
    {
        $data = $this->handler->saveUser(PartyAccess::getAccessRole());
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/create-teacher-user", name="api-user-createTeacherUser")
     */
    public function apiUserCreateTeacherUser()
    {
        $data = $this->handler->saveUserByCode();
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/create-university-user", name="api-user-createUniversityUser")
     */
    public function apiUserCreateUniversityUser()
    {
        $data = $this->handler->saveUserByCode();
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/user/reset-password", name="api-user-resetPassword")
     */
    public function apiUserResetPassword()
    {
        $data = $this->handler->resetPassword();
        return new JsonResponse($data);
    }
}
