<?php

namespace App\Controller\Email;

use App\Controller\API\Handler\CabinetHandler;
use App\Controller\API\Handler\PartyHandler;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class SendGridController
 * @package App\Controller\Email
 *
 * @property MailerService $mailer
 */
class SendGridController extends AbstractController
{
    private $mailer;

    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/email/test", name="email-test")
     */
    public function emailTest(Request $request)
    {
        $url = $this->generateUrl('api-user-confirmEmail', ['code' => 'asd12asda3']);
        $url = $request->getScheme().'://'.$request->getHost().$url;
        $data = $this->mailer->send('agoodminute@gmail.com', 'confirm-email-ua', ['link' => $url]);
        //$data = $url;
        return new JsonResponse($data);
    }

}
