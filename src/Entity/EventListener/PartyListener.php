<?php
namespace App\Entity\EventListener;

use App\Entity\Party;
use App\Handler\for_entity\PartyHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PartyListener
{
    private $handler;

    public function __construct(PartyHandler $handler)
    {
        $this->handler = $handler;
    }

    public function postLoad(Party $model, LifecycleEventArgs $args)
    {
        $model->handler = $this->handler;
        return;
    }
}