<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;

class MailServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $this->mailer = $this->prophesize(\Swift_Mailer::class);
        $this->twig = $this->prophesize(Environment::class);
        $this->translator = $this->prophesize(TranslatorInterface::class);
        $this->requestStack = $this->prophesize(RequestStack::class);

        $this->service = new MailService(
            $this->mailer->reveal(),
            $this->twig->reveal(),
            $this->translator->reveal(),
            $this->requestStack->reveal(),
            'from@symfony.local',
            ['bcc@symfony.local']
        );
    }

    /**
     * @test
     */
    public function itSendsAnEmail()
    {
        $this->requestStack->getCurrentRequest()->willReturn(new Request());
        $this->translator->trans('email.from_name', [], null, 'en')->shouldBeCalled();
        $this->translator->trans('subject', [], null, 'en')->shouldBeCalled();
        $this->twig->render('template.html.twig', ['locale' => 'en'])->shouldBeCalled();
        $this->twig->render('template.txt.twig', ['locale' => 'en'])->shouldBeCalled();
        $this->mailer->createMessage()->willReturn(new \Swift_Message());
        $this->mailer->send(Argument::type(\Swift_Message::class))->shouldBeCalled();

        $this->service->send('to@symfony.local', 'subject', 'template');
    }

    /**
     * @test
     */
    public function itSendsAnEmailWithSpecificLocale()
    {
        $this->translator->trans('email.from_name', [], null, 'es')->shouldBeCalled();
        $this->translator->trans('subject', [], null, 'es')->shouldBeCalled();
        $this->twig->render('template.html.twig', ['locale' => 'es'])->shouldBeCalled();
        $this->twig->render('template.txt.twig', ['locale' => 'es'])->shouldBeCalled();
        $this->mailer->createMessage()->willReturn(new \Swift_Message());
        $this->mailer->send(Argument::type(\Swift_Message::class))->shouldBeCalled();

        $this->service->setLocale('es');
        $this->service->send('to@symfony.local', 'subject', 'template');
    }
}
