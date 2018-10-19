<?php

namespace Runroom\BaseBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;

class MailService
{
    protected $mailer;
    protected $twig;
    protected $translator;
    protected $requestStack;
    protected $from;
    protected $bcc;
    protected $locale;

    public function __construct(
        \Swift_Mailer $mailer,
        Environment $twig,
        TranslatorInterface $translator,
        RequestStack $requestStack,
        string $from,
        array $bcc
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        $this->from = $from;
        $this->bcc = $bcc;
    }

    public function send(string $to, string $subject, string $template, array $parameters = []): void
    {
        $parameters = \array_merge($parameters, [
            'locale' => $this->getLocale(),
        ]);

        $message = $this->mailer->createMessage()
            ->setFrom([$this->from => $this->translate('email.from_name')])
            ->setTo($to)
            ->setBCC($this->bcc)
            ->setSubject($this->translate($subject))
            ->setBody(
                $this->twig->render($template . '.html.twig', $parameters),
                'text/html'
            )
            ->addPart(
                $this->twig->render($template . '.txt.twig', $parameters),
                'text/plain'
            );

        $this->mailer->send($message);
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        if (\is_null($this->locale)) {
            $this->locale = $this->requestStack->getCurrentRequest()->getLocale();
        }

        return $this->locale;
    }

    protected function translate(string $key)
    {
        return $this->translator->trans($key, [], null, $this->getLocale());
    }
}
