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

        $data = $this->getUser();

        if ($data) {
            $data = $data->serialize();
        } else {
            $data = null;
        }

        $response = [
            'user' => $data,
            'error' => $error,
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
            'user' => $this->getUser()->serialize(),
        ];
        return new JsonResponse($response);
    }
}
