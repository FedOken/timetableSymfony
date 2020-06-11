<?php
namespace App\Entity\EventListener;

use App\Service\Access\AccessService;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;

class BaseListener
{
    protected $em;
    protected $strService;
    protected $access;

    public function __construct(EntityManagerInterface $em, AccessService $access, StringService $strService)
    {
        $this->em = $em;
        $this->access = $access;
        $this->strService = $strService;
    }
}
