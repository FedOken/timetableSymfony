<?php

namespace App\Controller\ReactController;

use App\Controller\ReactController\Handler\UserHandler;
use App\Entity\User;
use App\Security\LoginFormAuthenticator;
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
     * @Route("/api/user/logout-end", name="api-user-logoutEnd")
     * @return JsonResponse
     */
    public function apiUserLogoutEnd()
    {
        return new JsonResponse(['status' => true]);
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
}
