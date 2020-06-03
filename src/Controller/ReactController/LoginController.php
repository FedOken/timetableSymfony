<?php

namespace App\Controller\ReactController;

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/react/login/get-csrf-token", name="react-login-getCsrfToken")
     *
     * @return JsonResponse
     */
    public function reactLoginGetCsrfToken()
    {
        $token = $this->container->get('security.csrf.token_manager')->getToken('authenticate')->getValue();

        return new JsonResponse($token);
    }

    /**
     * Entry poin for log-in
     * @Route("/react/login/login", name="react-login-login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return void
     */
    public function reactLoginLogin(AuthenticationUtils $authenticationUtils) {}

    /**
     * End point for log0in
     * @Route("/react/login/response", name="react-login-response")
     * @param Request $request
     * @return JsonResponse
     */
    public function reactLoginResponse(Request $request)
    {
        $response = [
            'status' => $request->getSession()->get(LoginFormAuthenticator::LOGIN_STATUS),
            'reasonCode' => $request->getSession()->get(LoginFormAuthenticator::REASON_CODE),
            'reason' => $request->getSession()->get(LoginFormAuthenticator::REASON),
            'code' => $request->getSession()->get(LoginFormAuthenticator::USER_CODE),
            'user' => $this->getUser() ? $this->getUser()->serialize() : null,
        ];
        return new JsonResponse($response);
    }
}
