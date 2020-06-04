<?php
namespace App\Entity\EventListener;

use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;

class BaseListener
{
    protected $em;
    protected $strService;

    public function __construct(EntityManagerInterface $em, StringService $strService)
    {
        $this->em = $em;
        $this->strService = $strService;
    }
}