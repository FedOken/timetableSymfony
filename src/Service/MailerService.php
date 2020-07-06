<?php

namespace App\Service;

use App\Entity\SendGridTemplate;
use App\Repository\SendGridTemplateRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MailerService
 * @package App\Service
 *
 * @property EntityManagerInterface $em
 */
class MailerService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $recipientEmail
     * @param string $slug
     * @param array $params
     * @param string $sender
     * @return bool|\SendGrid\Response|string
     * @throws \SendGrid\Mail\TypeException
     */
    public function send(string $recipientEmail, string $slug, array $params = [], string $sender = '')
    {
        /** @var SendGridTemplateRepository $repo */
        $repo = $this->em->getRepository(SendGridTemplate::class);
        $templateModel = $repo->findOneBy(['slug' => $slug]);
        if (!$templateModel) return false;

        $sender = $sender ?: SendGridTemplate::ADMIN_EMAIL;

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($sender, "Schedule");
        $email->addTo($recipientEmail, "", $params);
        $email->setTemplateId($templateModel->template_id);

        $sg = new \SendGrid(SendGridTemplate::API_KEY);
        try {
            $sg->send($email);
            return true;
        } catch (\Exception $e) {
            return 'Caught exception: '.$e->getMessage();
        }
    }
}