<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MailService implements LocaleAwareInterface
{
    protected $mailer;
    protected $translator;
    protected $from;
    protected $bcc;
    protected $locale;

    public function __construct(
        MailerInterface $mailer,
        TranslatorInterface $translator,
        string $from,
        array $bcc
    ) {
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function send(string $to, string $subject, string $template, array $parameters = []): void
    {
        $parameters = \array_merge($parameters, [
            'locale' => $this->getLocale(),
        ]);

        $email = (new TemplatedEmail())
            ->from(new Address($this->from, $this->translate('email.from_name')))
            ->to($to)
            ->bcc(...$this->bcc)
            ->subject($this->translate($subject))
            ->htmlTemplate($template . '.html.twig')
            ->textTemplate($template . '.txt.twig')
            ->context($parameters);

        $this->mailer->send($email);
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    protected function translate(string $key)
    {
        return $this->translator->trans($key, [], null, $this->getLocale());
    }
}
