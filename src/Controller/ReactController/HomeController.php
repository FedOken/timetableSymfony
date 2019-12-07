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

class HomeController extends AbstractController
{
    /**
     * @Route("/react/home/get-university", name="react-home-getUniversity")
     * @return JsonResponse
     */
    public function getUniversity()
    {
        $universitiesModel = $this->getDoctrine()->getRepository(University::class)->findAll();

        $response = [];
        /**@var University $university*/
        foreach ($universitiesModel as $university) {
            $response[] = ['value' => $university->id, 'label' => $university->name];
        }

        return new JsonResponse($response);
    }

    /**
 * @Route("/react/home/get-parties-all", name="react-home-getPartiesAll")
 * @return JsonResponse
 */
    public function getPartiesAll()
    {
        $parties = $this->getDoctrine()->getRepository(Party::class)->findAll();

        $response = [];
        /**@var Party $party*/
        foreach ($parties as $party) {
            $response[] = ['value' => $party->id, 'label' => $party->name];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/react/home/get-parties/{query}", name="react-home-getParties-query")
     * @param string $query
     * @return JsonResponse
     */
    public function getPartiesQuery($query)
    {
        if ($query === 'undefined') {
            return new JsonResponse([]);
        }

        $parties = $this->getDoctrine()->getRepository(Party::class)->findByName($query);

        $response = [];
        /**@var Party $party*/
        foreach ($parties as $party) {
            $response[] = ['id' => $party->id, 'label' => $party->name];
        }

        return new JsonResponse($response);
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