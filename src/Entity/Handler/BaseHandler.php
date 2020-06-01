<?php

namespace App\Entity\Handler;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseHandler
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        //Manager
        $this->em = $entityManager;
    }

    public abstract function validate(): bool;
}