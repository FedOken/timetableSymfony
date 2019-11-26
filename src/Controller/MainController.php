<?php

namespace App\Controller;

use App\Entity\Day;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function main()
    {
        $repository = $this->getDoctrine()->getRepository(Day::class);

        $model_days = $repository->findAll();


        return $this->render('main/index.html.twig', ['model_days' => $model_days]);
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
