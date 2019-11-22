<?php

namespace App\Handler;

use App\Entity\Faculty;
use App\Entity\University;
use App\Entity\User;
use App\Repository\FacultyRepository;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;

class FacultyHandler
{
    protected $accessService;
    protected $em;

    public function __construct(AccessService $accessService, EntityManagerInterface $entityManager)
    {
        $this->accessService = $accessService;
        $this->em = $entityManager;
    }

    /**
     * Set select2 data by permission and selected entity
     * @param int|null $currentId
     * @param User|object $user
     * @return array
     */
    public function setSelect2EasyAdmin($currentId, $user)
    {
        $universityPermission = $this->accessService->getAccessObject($user)->getAccessibleUniversityIds();
        $entityModels = $this->em->getRepository(Faculty::class)->getByUniversity($universityPermission);

        if ($currentId) {
            $currentModel = [];
            foreach ($entityModels as $key => $model) {
                if ($model->id === $currentId) {
                    $currentModel[] = $model;
                    unset($entityModels[$key]);
                    break;
                }
            }
            return array_merge($currentModel, $entityModels);
        }

        return $entityModels;
    }

}