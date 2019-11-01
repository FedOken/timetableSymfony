<?php

namespace App\Controller\EasyAdmin;


use App\Service\AccessService;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;


class UniversityController extends EasyAdminController
{
    protected $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    protected function listAction()
    {
        if ($this->isGranted(AccessService::ROLE_ADMIN)) {
            return parent::listAction();
        } else {
            $universityIds = $this->accessService->getUniversityPermission($this->getUser());
            return $this->redirect('?action=show&entity=University&id='.$universityIds[0]);
        }
    }

    protected function editAction()
    {
        if ($this->isGranted(AccessService::ROLE_UNIVERSITY_MANAGER)) {
            return parent::editAction();
        } else {
            $universityIds = $this->accessService->getUniversityPermission($this->getUser());
            return $this->redirect('?action=show&entity=University&id='.$universityIds[0]);
        }
    }
}
