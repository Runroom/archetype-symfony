<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Service\MailService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class MailServiceTest extends TestCase
{
    private MockObject&MailerInterface $mailer;
    private Stub&TranslatorInterface $translator;
    private MailService $service;

    #[\Override]
    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->translator = static::createStub(TranslatorInterface::class);

        $this->service = new MailService(
            $this->mailer,
            $this->translator,
            'from@symfony.local',
            ['bcc@symfony.local']
        );
    }

    public function testItSendsAnEmail(): void
    {
        $this->translator->method('trans')->willReturnMap([
            ['email.from_name', [], null, 'en', 'From Name'],
            ['subject', [], null, 'en', 'Subject'],
        ]);
        $this->mailer->expects(static::once())->method('send')->with(static::isInstanceOf(TemplatedEmail::class));

        $this->service->setLocale('en');
        $this->service->send('to@symfony.local', 'subject', 'template');
    }
}
