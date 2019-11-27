<?php

namespace App\Controller\ReactController;

use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReactController extends AbstractController
{
    /**
     * @Route("/react/login", name="react-login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return JsonResponse
     */
    public function login(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $serializer = $this->container->get('serializer');

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($this->getUser(), 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->id;
            }
        ]);

        $response = [
            'user' => json_decode($jsonObject),
            'token' => $this->container->get('security.csrf.token_manager')->getToken('authenticate')->getValue(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'lastUsername' => $authenticationUtils->getLastUsername()
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/react/login/login", name="react-login-login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return JsonResponse
     */
    public function logins(AuthenticationUtils $authenticationUtils): Response
    {

        $serializer = $this->container->get('serializer');

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($this->getUser(), 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->id;
            }
        ]);

        $response = [
            'user' => $jsonObject,
            'token' => $this->container->get('security.csrf.token_manager')->getToken('authenticate')->getValue(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'lastUsername' => $authenticationUtils->getLastUsername()
        ];

        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/react/test", name="react-test")
     * @param Request $request
     * @return JsonResponse
     */
    public function setLanguage(Request $request)
    {
        $response = [1, 2, 'test', 'TT' => 'ww'];
        return new JsonResponse($response);
    }
}
