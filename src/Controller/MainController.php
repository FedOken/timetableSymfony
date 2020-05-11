<?php

namespace App\Controller;

use App\Entity\Day;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function main()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcome()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/schedule", name="schedule")
     */
    public function schedule()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/contact/business", name="contact/business")
     */
    public function contactBusiness()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/contact/technical", name="contact/technical")
     */
    public function contactTechnical()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/register/confirm-email-send", name="register/confirm-email-send")
     */
    public function registerConfirmEmailSend()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/reset-password", name="reset-password")
     */
    public function resetPassword()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/reset-password/email-send", name="reset-password/email-send")
     */
    public function resetPasswordEmailSend()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('welcome/index.html.twig');
    }

    /**
     * @Route("/schedule/{type}/{party_id}", name="schedule-type-partyId")
     */
    public function scheduleTypePartyId()
    {
        return $this->render('welcome/index.html.twig');
    }

}