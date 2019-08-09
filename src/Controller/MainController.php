<?php

namespace App\Controller;

use App\Entity\Day;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function main()
    {
        $repository = $this->getDoctrine()->getRepository(Day::class);

        $model_days = $repository->findAll();


        return $this->render('main/index.html.twig', ['model_days' => $model_days]);
    }
}
