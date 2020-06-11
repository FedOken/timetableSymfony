<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\UserHandler;
use App\Entity\User;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener extends BaseListener
{
    /**
     * After model load
     * @param User $model
     * @param LifecycleEventArgs $args
     */
    public function postLoad(User $model, LifecycleEventArgs $args)
    {
        $model->handler = new UserHandler($model);
        return;
    }

    /**
     * Before model save first
     * @param User $model
     * @param LifecycleEventArgs $args
     */
    public function prePersist(User $model, LifecycleEventArgs $args)
    {
        $model->code = $this->strService->genRanStrEntity(5, User::class, 'code');
        return;
    }
}
