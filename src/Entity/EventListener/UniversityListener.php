<?php
namespace App\Entity\EventListener;

use App\Entity\University;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;

class UniversityListener extends BaseListener
{
    public function prePersist(University $model, LifecycleEventArgs $args)
    {
        $model->enable = $model->enable ?: true;
        $model->access_code = $this->strService->genRanStrEntity(10, University::class, 'access_code');
        return;
    }

    public function postUpdate(University $model, LifecycleEventArgs $args)
    {
        $model->access_code = $this->strService->genRanStrEntity(10, University::class, 'access_code');
//        foreach ($model->faculties as $faculty) {
//            $faculty->enable = $model->enable;
//            $this->em->persist($faculty);
//            $this->em->flush();
//        }
        return;
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
//        $em = $eventArgs->getEntityManager();
//        $uow = $em->getUnitOfWork();
//        $updates = $uow->getScheduledEntityUpdates();
//        $model = array_shift($updates);
//        foreach ($model->faculties as $faculty) {
//            $faculty->enable = $model->enable;
//            //$this->em->persist($faculty);
//            //$this->em->flush();
//        }

        return;
    }
}