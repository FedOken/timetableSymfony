<?php


namespace App\Handler;


use App\Entity\User;
use App\Repository\UniversityRepository;
use App\Service\AccessService;

class UniversityHandler
{
    protected $accessService;
    protected $universityRepo;

    public function __construct(AccessService $accessService, UniversityRepository $universityRepo)
    {
        //Access service
        $this->accessService = $accessService;
        //Repository
        $this->universityRepo = $universityRepo;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $universityPermission = $this->accessService->getUniversityPermission($user);
        $universityModels = $this->universityRepo->getUniversityByUniversity($universityPermission);

        if ($currentId) {
            $currentModel = [];
            foreach ($universityModels as $key => $model) {
                if ($model->id === $currentId) {
                    $currentModel[] = $model;
                    unset($universityModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $universityModels);
        }

        return $universityModels;
    }

}