<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\UserHandler;
use App\Entity\User;
use App\Handler\for_entity\WeekHandler;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener
{
    private $handler;

    public function __construct(UserHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * After model load
     * @param User $model
     * @param LifecycleEventArgs $args
     */
    public function postLoad(User $model, LifecycleEventArgs $args)
    {
        $model->handler = $this->handler;
        return;
    }

    /**
     * After model save
     * @param User $model
     * @param LifecycleEventArgs $args
     */
    public function postPersist(User $model, LifecycleEventArgs $args)
    {
    }


}