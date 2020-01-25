<?php

namespace App\Controller\ReactController;

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ReactController extends AbstractController
{
    /**
     * @Route("/react/login/get-user-data", name="react-login-getUserData")
     *
     * @return JsonResponse
     */
    public function reactLoginGetUserData()
    {
        $token = $this->container->get('security.csrf.token_manager')->getToken('authenticate')->getValue();

        return new JsonResponse($token);
    }

    /**
     * @Route("/react/login/login", name="react-login-login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return JsonResponse
     */
    public function reactLoginLogin(AuthenticationUtils $authenticationUtils)
    {
        $token = $this->container->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $response = [
            'user' => 'seffe',
            'token' => $token,
            'error' => $error,
            'lastUsername' => $lastUsername
        ];

        return new JsonResponse($response);
    }


    /**
     * @Route("/react/login/response", name="react-login-response")
     * @param Request $request
     * @return JsonResponse
     */
    public function setLanguage(Request $request)
    {
        $response = [
            'status' => $request->getSession()->get(LoginFormAuthenticator::LOGIN_STATUS),
            'reason' => $request->getSession()->get(LoginFormAuthenticator::REASON),
        ];
        return new JsonResponse($response);
    }
}
