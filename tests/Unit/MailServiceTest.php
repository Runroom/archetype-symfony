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

class MailServiceTest extends TestCase
{
    /**
     * @var MockObject&MailerInterface
     */
    private MockObject $mailer;

    /**
     * @var Stub&TranslatorInterface
     */
    private Stub $translator;

    private MailService $service;

    protected function setUp(): void
    {
        $this->mailer = $this->createMock(MailerInterface::class);
        $this->translator = $this->createStub(TranslatorInterface::class);

        $this->service = new MailService(
            $this->mailer,
            $this->translator,
            'from@symfony.local',
            ['bcc@symfony.local']
        );
    }

    /**
     * @test
     */
    public function itSendsAnEmail(): void
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
