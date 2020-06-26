<?php


namespace App\Controller\EasyAdmin\Handler;


use App\Entity\User;
use App\Repository\UniversityRepository;
use App\Service\Access\AccessService;
use Doctrine\ORM\EntityManagerInterface;

class BaseHandler
{
    protected $access;
    protected $em;

    public function __construct(AccessService $access, EntityManagerInterface $em)
    {
        //Access service
        $this->access = $access;
        $this->em = $em;
    }
}