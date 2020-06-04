<?php

namespace Tests\Unit;

use App\Service\MailService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MailServiceTest extends TestCase
{
    use ProphecyTrait;

    /** @var ObjectProphecy<MailerInterface> */
    private $mailer;

    /** @var ObjectProphecy<TranslatorInterface> */
    private $translator;

    /** @var MailService */
    private $service;

    protected function setUp(): void
    {
        $this->mailer = $this->prophesize(MailerInterface::class);
        $this->translator = $this->prophesize(TranslatorInterface::class);

        $this->service = new MailService(
            $this->mailer->reveal(),
            $this->translator->reveal(),
            'from@symfony.local',
            ['bcc@symfony.local']
        );
    }

    /** @test */
    public function itSendsAnEmail(): void
    {
        $this->translator->trans('email.from_name', [], null, 'en')->willReturn('From Name');
        $this->translator->trans('subject', [], null, 'en')->willReturn('Subject');
        $this->mailer->send(Argument::type(TemplatedEmail::class))->shouldBeCalled();

        $this->service->setLocale('en');
        $this->service->send('to@symfony.local', 'subject', 'template');
    }
}
