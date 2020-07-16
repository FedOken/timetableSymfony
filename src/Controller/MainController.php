<?php

namespace App\Controller;

use App\Controller\API\Handler\TeacherHandler;
use App\Controller\Handler\MainHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class MainController
 * @package App\Controller
 *
 * @property MainHandler $handler
 */
class MainController extends AbstractController
{
    private $handler;

    public function __construct(MainHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/", name="home")
     */
    public function main()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/schedule", name="schedule")
     */
    public function schedule()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search()
    {
        $data = $this->handler->formSearchData();
        return $this->render('search/index.html.twig', $data);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('contact/index.html.twig');
    }

    /**
     * @Route("/contact/business", name="contact/business")
     */
    public function contactBusiness()
    {
        return $this->render('contact/index.html.twig');
    }

    /**
     * @Route("/contact/technical", name="contact/technical")
     */
    public function contactTechnical()
    {
        return $this->render('contact/index.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/reset-password", name="reset-password")
     */
    public function resetPassword()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/reset-password/email-send", name="reset-password/email-send")
     */
    public function resetPasswordEmailSend()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/schedule/{type}/{party_id}", name="schedule-type-partyId")
     */
    public function scheduleTypePartyId()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/register/confirm-email-send/{code}", name="register-confirmEmailSend")
     */
    public function registerConfirmEmailSend(string $code)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/register/confirm-email/{code}", name="register-confirmEmail")
     */
    public function registerConfirmEmail(string $code)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/term-of-use", name="termOfUse")
     */
    public function termOfUse()
    {
        return $this->render('default/index.html.twig');
    }
}
