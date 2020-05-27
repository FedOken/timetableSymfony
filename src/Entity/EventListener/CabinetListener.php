<?php
namespace App\Entity\EventListener;

use App\Entity\Cabinet;
use App\Handler\for_entity\CabinetHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CabinetListener
{
    private $handler;

    public function __construct(CabinetHandler $handler)
    {
        $this->handler = $handler;
    }

    public function postLoad(Cabinet $model, LifecycleEventArgs $args)
    {
        $model->handler = $this->handler;
        return;
    }
}