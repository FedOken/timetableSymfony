<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\PartyHandler;
use App\Entity\Party;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PartyListener
{
    /**
     * After model load
     * @param Party $model
     * @param LifecycleEventArgs $args
     */
    public function postLoad(Party $model, LifecycleEventArgs $args)
    {
        $model->handler = new PartyHandler($model);
        return;
    }
}