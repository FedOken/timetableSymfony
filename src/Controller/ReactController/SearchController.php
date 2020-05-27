<?php

namespace App\Controller\ReactController;

use App\Entity\Party;
use App\Entity\University;
use App\Handler\for_controller\react\SearchHandler;
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
    private $srchHandler;

    public function __construct(SearchHandler $searchHandler)
    {
        $this->srchHandler = $searchHandler;
    }

    /**
     * @Route("/react/search/get-universities", name="react-search-getUniversities")
     * @return JsonResponse
     */
    public function reactSearchGetUniversities()
    {
        $data = $this->srchHandler->getUniversities();
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-teachers/{unId}", name="react-search-getTeachers")
     * @param int $unId
     * @return JsonResponse
     */
    public function reactSearchGetTeachers(int $unId)
    {
        $data = $this->srchHandler->getTeachers($unId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-buildings/{unId}", name="react-search-getBuildings")
     * @param int $unId
     * @return JsonResponse
     */
    public function reactSearchGetBuildings(int $unId)
    {
        $data = $this->srchHandler->getBuildings($unId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-cabinets/{buildingId}", name="react-search-getCabinets")
     * @param int $buildingId
     * @return JsonResponse
     */
    public function reactSearchGetCabinets(int $buildingId)
    {
        $data = $this->srchHandler->getCabinets($buildingId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-parties/{unId}", name="react-search-getParties")
     * @param int $unId
     * @return JsonResponse
     */
    public function reactSearchGetParties(int $unId)
    {
        $data = $this->srchHandler->getParties($unId);
        return new JsonResponse($data);
    }


    /**
     * @Route("/react/search/get-parties-autocomplete/{query}", name="react-search-getPartiesAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetPartiesAutocomplete($query)
    {
        $data = $this->srchHandler->getPartiesAutocomplete($query);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-teachers-autocomplete/{query}", name="react-search-getTeachersAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetTeachersAutocomplete($query)
    {
        $data = $this->srchHandler->getTeachersAutocomplete($query);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-cabinets-autocomplete/{query}", name="react-search-getCabinetsAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetCabinetsAutocomplete($query)
    {
        $data = $this->srchHandler->getCabinetsAutocomplete($query);
        return new JsonResponse($data);
    }
}
