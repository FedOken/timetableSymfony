<?php

namespace App\Controller\ReactController;


use App\Controller\ReactController\Handler\SearchHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    private $handler;

    public function __construct(SearchHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/react/search/get-universities", name="react-search-getUniversities")
     * @return JsonResponse
     */
    public function reactSearchGetUniversities()
    {
        $data = $this->handler->getUniversities();
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-teachers/{unId}", name="react-search-getTeachers")
     * @param int $unId
     * @return JsonResponse
     */
    public function reactSearchGetTeachers(int $unId)
    {
        $data = $this->handler->getTeachers($unId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-buildings/{unId}", name="react-search-getBuildings")
     * @param int $unId
     * @return JsonResponse
     */
    public function reactSearchGetBuildings(int $unId)
    {
        $data = $this->handler->getBuildings($unId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-cabinets/{buildingId}", name="react-search-getCabinets")
     * @param int $buildingId
     * @return JsonResponse
     */
    public function reactSearchGetCabinets(int $buildingId)
    {
        $data = $this->handler->getCabinets($buildingId);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-parties/{unId}", name="react-search-getParties")
     * @param int $unId
     * @return JsonResponse
     */
    public function reactSearchGetParties(int $unId)
    {
        $data = $this->handler->getParties($unId);
        return new JsonResponse($data);
    }


    /**
     * @Route("/react/search/get-parties-autocomplete/{query}", name="react-search-getPartiesAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetPartiesAutocomplete($query)
    {
        $data = $this->handler->getPartiesAutocomplete($query);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-teachers-autocomplete/{query}", name="react-search-getTeachersAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetTeachersAutocomplete($query)
    {
        $data = $this->handler->getTeachersAutocomplete($query);
        return new JsonResponse($data);
    }

    /**
     * @Route("/react/search/get-cabinets-autocomplete/{query}", name="react-search-getCabinetsAutocomplete")
     * @param string $query
     * @return JsonResponse
     */
    public function reactSearchGetCabinetsAutocomplete($query)
    {
        $data = $this->handler->getCabinetsAutocomplete($query);
        return new JsonResponse($data);
    }
}
