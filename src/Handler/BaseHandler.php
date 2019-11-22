<?php


namespace App\Handler;


use App\Entity\User;
use App\Repository\UniversityRepository;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;

class BaseHandler
{
    protected $accessService;
    protected $em;

    public function __construct(AccessService $accessService, EntityManagerInterface $entityManager)
    {
        //Access service
        $this->accessService = $accessService;
        //Manager
        $this->em = $entityManager;
    }
}