<?php

namespace App\Controller\API\Handler;

use App\Entity\Building;
use App\Entity\Contact;
use App\Entity\SendGridTemplate;
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

            $this->sendContactEmail($model);
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

    /**
     * @param Contact $model
     * @return bool
     * @throws \SendGrid\Mail\TypeException
     */
    private function sendContactEmail($model): bool
    {
        $title = $model->type == Contact::TYPE_BUSINESS ? 'New business message' : 'New technical message';
        return $this->mailer->send(SendGridTemplate::ADMIN_EMAIL, 'new-contact-letter', [
            'title' => $title,
            'message' => $model->message,
            'phone' => $model->phone,
            'email' => $model->email,
        ], 'agoodminute@gmail.com');
    }
}