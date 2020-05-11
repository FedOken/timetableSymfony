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

class SearchController extends AbstractController
{
    /**
     * @Route("/react/search/get-universities", name="react-search-getUniversities")
     * @return JsonResponse
     */
    public function reactSearchGetUniversities()
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
     * @Route("/react/search/get-parties/{universityId}", name="react-search-getParties")
     * @param int $universityId
     * @return JsonResponse
     */
    public function reactSearchGetParties(int $universityId)
    {
        $parties = $this->getDoctrine()->getRepository(Party::class)->findByUniversity($universityId);

        $response = [];
        /**@var Party $party*/
        foreach ($parties as $party) {
            $response[] = ['value' => $party->id, 'label' => $party->name];
        }

        return new JsonResponse($response);
    }


    /**
     * @Route("/react/search/get-parties-autocomplete/{query}", name="react-search-getPartiesAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetPartiesAutocomplete($query)
    {
        $query = trim($query);

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
}
