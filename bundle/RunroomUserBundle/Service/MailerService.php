<?php

declare(strict_types=1);

namespace Runroom\UserBundle\Service;

use Runroom\UserBundle\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

final class MailerService
{
    private MailerInterface $mailer;
    private TranslatorInterface $translator;
    private string $fromEmail;
    private string $fromName;

    public function __construct(
        MailerInterface $mailer,
        TranslatorInterface $translator,
        string $fromEmail,
        string $fromName
    ) {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }

    public function sendResetPasswordEmail(User $user, ResetPasswordToken $resetToken): void
    {
        $email = $user->getEmail();

        if (null === $email) {
            return;
        }

        $this->mailer->send((new TemplatedEmail())
            ->from(new Address($this->fromEmail, $this->fromName))
            ->to($email)
            ->subject($this->translator->trans('email.subject'))
            ->htmlTemplate('@RunroomUser/email/reset.html.twig')
            ->textTemplate('@RunroomUser/email/reset.txt.twig')
            ->context([
                'userEmail' => $email,
                'resetToken' => $resetToken,
            ]));
    }
}
