<?php
namespace App\Entity\EventListener;

use App\Entity\Handler\UserHandler;
use App\Entity\User;
use App\Handler\for_entity\WeekHandler;
use App\Helper\EnvHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class UserListener
{
    private $em;
    private $handler;

    public function __construct(UserHandler $handler, EntityManagerInterface $em)
    {
        $this->handler = $handler;
        $this->em = $em;
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
     * Before model save
     * @param User $model
     * @param LifecycleEventArgs $args
     */
    public function prePersist(User $model, LifecycleEventArgs $args)
    {
        $model->code = $this->createCode();
        return;
    }

    private function createCode(): string
    {
        $code = EnvHelper::generateRandomStr(5);
        if ($this->em->getRepository(User::class)->findOneBy(['code' => $code])) {
            $this->createCode();
        };
        return $code;
    }


}