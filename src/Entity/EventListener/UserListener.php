<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\UserHandler;
use App\Entity\User;
use App\Handler\for_entity\WeekHandler;
use App\Helper\EnvHelper;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener extends BaseListener
{
    private $handler;

    public function __construct(EntityManagerInterface $em, StringService $strService, UserHandler $handler)
    {
        $this->handler = $handler;
        parent::__construct($em, $strService);
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