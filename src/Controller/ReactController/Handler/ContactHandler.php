<?php

namespace App\Controller\ReactController\Handler;

use App\Entity\Building;
use App\Entity\Contact;
use App\Entity\User;
use App\Repository\BuildingRepository;
use App\Repository\ContactRepository;
use App\Service\Access\AccessService;
use App\Service\StringService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class ContactHandler extends BaseHandler
{
    public function sendContactLetter(): array
    {
        try {
            $model = new Contact();
            $model->load($this->request->request->get('Contact'));
            $model->status = Contact::STATUS_NEW;

            $this->em->persist($model);
            $this->em->flush();

            return [
                'status' => true,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}