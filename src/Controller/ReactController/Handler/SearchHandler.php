<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Party;
use App\Entity\Teacher;
use App\Entity\University;
use App\Handler\BaseHandler;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use App\Repository\TeacherRepository;
use App\Repository\UniversityRepository;

class SearchHandler extends BaseHandler
{
    /**
     * Return all universities
     * @return array
     */
    public function getUniversities(): array
    {
        /**@var UniversityRepository $unRepo */
        $unRepo = $this->em->getRepository(University::class);
        $unModels = $unRepo->findAll();

        $response = [];
        /**@var University $model */
        foreach ($unModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return parties for selected university
     * @param int $unId
     * @return array
     */
    public function getParties(int $unId): array
    {
        /**@var PartyRepository $prtRepo */
        $prtRepo = $this->em->getRepository(Party::class);
        $prtModels = $prtRepo->findByUniversity($unId);

        $response = [];
        /**@var Teacher $model */
        foreach ($prtModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return teachers for selected university
     * @param int $unId
     * @return array
     */
    public function getTeachers(int $unId): array
    {
        /**@var TeacherRepository $tchrRepo */
        $tchrRepo = $this->em->getRepository(Teacher::class);
        $tchrModels = $tchrRepo->findBy(['university' => $unId]);

        $response = [];
        /**@var Teacher $model */
        foreach ($tchrModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return building for selected university
     * @param int $unId
     * @return array
     */
    public function getBuildings(int $unId): array
    {
        /**@var TeacherRepository $tchrRepo */
        $bldngRepo = $this->em->getRepository(Building::class);
        $bldngModels = $bldngRepo->findBy(['university' => $unId], ['name' => 'ASC']);

        $response = [];
        /**@var Building $model */
        foreach ($bldngModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return cabinets for selected building
     * @param int $buildingId
     * @return array
     */
    public function getCabinets(int $buildingId): array
    {
        /**@var CabinetRepository $cabinetRepo */
        $cabinetRepo = $this->em->getRepository(Cabinet::class);
        $cabinetModels = $cabinetRepo->findBy(['building' => $buildingId], ['name' => 'ASC']);

        $response = [];
        /**@var Cabinet $model */
        foreach ($cabinetModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return autocomplete result
     * @param string $query
     * @return array
     */
    public function getPartiesAutocomplete(string $query): array
    {
        $query = trim($query);
        if ($query === 'undefined') {
            return [];
        }

        /**@var PartyRepository $prtRepo */
        $prtRepo = $this->em->getRepository(Party::class);
        $prtModels = $prtRepo->findByname($query);

        $response = [];
        /**@var Teacher $model*/
        foreach ($prtModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return autocomplete result
     * @param string $query
     * @return array
     */
    public function getTeachersAutocomplete(string $query): array
    {
        $query = trim($query);
        if ($query === 'undefined') {
            return [];
        }

        /**@var TeacherRepository $tchrRepo */
        $tchrRepo = $this->em->getRepository(Teacher::class);
        $tchrModels = $tchrRepo->findByname($query);

        $response = [];
        /**@var Teacher $model*/
        foreach ($tchrModels as $model) {
            $response[] = ['value' => $model->id, 'label' => $model->name];
        }

        return $response;
    }

    /**
     * Return autocomplete result
     * @param string $query
     * @return array
     */
    public function getCabinetsAutocomplete(string $query): array
    {
        $query = trim($query);
        if ($query === 'undefined') {
            return [];
        }

        /**@var CabinetRepository $cabinetRepo */
        $cabinetRepo = $this->em->getRepository(Cabinet::class);
        $cabinetModels = $cabinetRepo->findByname($query);

        $response = [];
        /**@var Cabinet $model*/
        foreach ($cabinetModels as $model) {
            $building =  $model->building ? $model->building->name : null;
            $unModel = $model->building ? $model->building->university : null;
            $university = $unModel ? $unModel->name : null;

            $label = $model->name;
            $label = $building ? "$label - $building" : $label;
            $label = $university ? "$label - $university" : $label;

            $response[] = ['value' => $model->id, 'label' => $label];
        }

        return $response;
    }
}