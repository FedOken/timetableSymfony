<?php

namespace App\Controller\ReactController;

use App\Entity\Party;
use App\Entity\University;
use App\Helper\ArrayHelper;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class GroupController extends AbstractController
{
    /**
     * @Route("/group/show", name="group-show")
     */
    public function groupShow()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/react/home/get-parties/{universityId}", name="react-home-getParties")
     * @param int $universityId
     * @return JsonResponse
     */
    public function getParties(int $universityId)
    {
        /**@var University $university*/
        $university= $this->getDoctrine()->getRepository(University::class)->findOneBy(['id' => $universityId]);

        $parties = [];
        foreach ($university->faculties as $faculty) {
            $parties = array_merge($parties, $faculty->parties);
        }

        $response = [];
        /**@var Party $party*/
        foreach ($parties as $party) {
            $response[] = ['value' => $party->id, 'label' => $party->name];
        }

        return new JsonResponse($response);
    }
}
