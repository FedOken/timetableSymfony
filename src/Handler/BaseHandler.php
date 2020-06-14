<?php


namespace App\Handler;


use App\Entity\User;
use App\Repository\UniversityRepository;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;

class BaseHandler
{
    protected $access;

    public function __construct(AccessService $access)
    {
        //Access service
        $this->access = $access;
    }
}