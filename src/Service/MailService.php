<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class MailService implements LocaleAwareInterface
{
    /**
     * @see this property will be set through `setLocale()` method
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private string $locale;

    /**
     * @param string[] $bcc
     */
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly TranslatorInterface $translator,
        private readonly string $from,
        private readonly array $bcc
    ) {
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function send(string $to, string $subject, string $template, array $parameters = []): void
    {
        $parameters = [...$parameters, ...[
            'locale' => $this->locale,
        ]];

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

    private function translate(string $key): string
    {
        return $this->translator->trans($key, [], null, $this->locale);
    }
}
