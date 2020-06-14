<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    private $reasonCode = null;
    private $userCode = null;

    const LOGIN_STATUS = 'login_status';
    const USER_CODE = 'user_code';
    const REASON_CODE = 'login_reason_code';
    const REASON = 'login_reason';

    const CODE_INCORRECT_DATA= 100;
    const CODE_NEED_EMAIL_AUTH = 101;
    const CODE_ACCOUNT_DISABLED= 102;
    const CODE_BAD_TOKEN = 103;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return 'api-user-loginStart' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            //throw new InvalidCsrfTokenException();
            $this->reasonCode = self::CODE_BAD_TOKEN;
            throw new CustomUserMessageAuthenticationException('Incorrect token.');
        }

        /**@var User $user*/
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            $this->reasonCode = self::CODE_INCORRECT_DATA;
            throw new CustomUserMessageAuthenticationException('Incorrect email or password.');
        } else if($user->status === User::STATUS_WAIT_EMAIL_CONFIRM) {
            $this->reasonCode = self::CODE_NEED_EMAIL_AUTH;
            $this->userCode = $user->code;
            throw new CustomUserMessageAuthenticationException('Email not confirm. Please confirm your email address.');
        } else if($user->status === User::STATUS_UNACTIVE) {
            $this->reasonCode = self::CODE_ACCOUNT_DISABLED;
            throw new CustomUserMessageAuthenticationException('Your account is disabled. Contact us for details.');
        } else {
            $this->userIsValid = true;
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $passwordIsValid = $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        if (!$passwordIsValid) throw new CustomUserMessageAuthenticationException('Incorrect email or password.');
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $request->getSession()->set(self::LOGIN_STATUS, true);
        $request->getSession()->set(self::REASON_CODE, $this->reasonCode);
        $request->getSession()->set(self::USER_CODE, $this->userCode);
        $request->getSession()->set(self::REASON, 'You have successfully log-in!');

        return new RedirectResponse($this->urlGenerator->generate('api-user-loginEnd'));
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(self::LOGIN_STATUS, false);
        $request->getSession()->set(self::REASON_CODE, $this->reasonCode);
        $request->getSession()->set(self::USER_CODE, $this->userCode);
        $request->getSession()->set(self::REASON, $exception->getMessage());

        return new RedirectResponse($this->urlGenerator->generate('api-user-loginEnd'));
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('react-login-login');
    }
}
