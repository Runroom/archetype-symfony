<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\EventListener\LanguageSwitchListener;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LanguageSwitchListenerTest extends TestCase
{
    /**
     * @var string
     */
    private const COOKIE_NAME = 'language_switched';

    /**
     * @var string[]
     */
    private const LOCALES = ['en', 'es', 'ca'];

    /**
     * @var string
     */
    private const HOME_ROUTE = 'home';

    private MockObject&UrlGeneratorInterface $urlGenerator;
    private LanguageSwitchListener $listener;

    protected function setUp(): void
    {
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);

        $this->listener = new LanguageSwitchListener(
            new CrawlerDetect(),
            $this->urlGenerator,
            'home',
            self::LOCALES
        );
    }

    public function testItRedirectsToBrowserLanguage(): void
    {
        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [], [], [
                'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5',
            ]),
            HttpKernelInterface::MAIN_REQUEST
        );

        $this->urlGenerator->expects(static::once())->method('generate')
            ->with(self::HOME_ROUTE, ['_locale' => 'ca'])
            ->willReturn('/ca');

        ($this->listener)($event);

        static::assertTrue($event->isPropagationStopped());
        static::assertInstanceOf(RedirectResponse::class, $event->getResponse());
    }

    public function testItRedirectsToDefaultLanguageIfAcceptLanguageDoNotMatch(): void
    {
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5;q=0.5',
        ]);
        $request->setLocale('es');

        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            $request,
            HttpKernelInterface::MAIN_REQUEST
        );

        $this->urlGenerator->expects(static::once())->method('generate')
            ->with(self::HOME_ROUTE, ['_locale' => 'en'])
            ->willReturn('/en');

        ($this->listener)($event);

        static::assertTrue($event->isPropagationStopped());
        static::assertInstanceOf(RedirectResponse::class, $event->getResponse());
    }

    public function testItDoesNotRedirectIfLanguageIsNotAvailable(): void
    {
        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [], [], [
                'HTTP_ACCEPT_LANGUAGE' => 'fr-ca,fr;q=0.5',
            ]),
            HttpKernelInterface::MAIN_REQUEST
        );

        ($this->listener)($event);

        static::assertFalse($event->isPropagationStopped());
        static::assertNull($event->getResponse());
    }

    public function testItDoesNotRedirectIfLanguageCookieExists(): void
    {
        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [self::COOKIE_NAME => true], [], [
                'HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5',
            ]),
            HttpKernelInterface::MAIN_REQUEST
        );

        ($this->listener)($event);

        static::assertNull($event->getResponse());
    }

    public function testItDoesNotRedirectIfSubRequest(): void
    {
        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [], [], [
                'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5',
            ]),
            HttpKernelInterface::SUB_REQUEST
        );

        ($this->listener)($event);

        static::assertNull($event->getResponse());
    }
}
