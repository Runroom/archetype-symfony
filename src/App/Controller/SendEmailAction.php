<?php

namespace App\Controller;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SendEmailAction
{
    private $urlGenerator;
    private $userManager;
    private $mailer;
    private $tokenGenerator;
    private $resetTtl;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserManagerInterface $userManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator,
        int $resetTtl
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->userManager = $userManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->resetTtl = $resetTtl;
    }

    public function __invoke(Request $request): Response
    {
        $username = $request->request->get('username');
        $user = $this->userManager->findUserByUsernameOrEmail($username);

        if (null !== $user && $user->isAccountNonLocked()) {
            if (!$user->isPasswordRequestNonExpired($this->resetTtl)) {
                $user->setConfirmationToken($this->tokenGenerator->generateToken());
                $user->setPasswordRequestedAt(new \DateTime());
                $this->userManager->updateUser($user);
            }
            $this->mailer->sendResettingEmailMessage($user);
        }

        return new RedirectResponse($this->urlGenerator->generate('sonata_user_admin_resetting_check_email', [
            'username' => $username,
        ]));
    }
}
