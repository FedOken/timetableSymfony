<?php
namespace App\Entity\EventListener;

use App\Entity\Cabinet;
use App\Entity\Handler\CabinetHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CabinetListener
{
    /**
     * After model load
     * @param Cabinet $model
     * @param LifecycleEventArgs $args
     */
    public function postLoad(Cabinet $model, LifecycleEventArgs $args)
    {
        $model->handler = new CabinetHandler($model);
        return;
    }
}