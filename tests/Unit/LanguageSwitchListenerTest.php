<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\EventListener\LanguageSwitchListener;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LanguageSwitchListenerTest extends TestCase
{
    /**
     * @var string
     */
    private const string COOKIE_NAME = 'language_switched';

    /**
     * @var string[]
     */
    private const array LOCALES = ['es', 'en', 'ca'];

    /**
     * @var string
     */
    private const string HOME_ROUTE = 'home';

    private MockObject&UrlGeneratorInterface $urlGenerator;
    private LanguageSwitchListener $listener;

    #[\Override]
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

    #[DataProvider('provideRequestsAndRedirects')]
    public function testItRedirectsAndSetsCookie(Request $request, ?string $redirectLocale = null): void
    {
        $event = new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            new Response()
        );

        if (null !== $redirectLocale) {
            $this->urlGenerator->expects(static::once())->method('generate')
                ->with(self::HOME_ROUTE, ['_locale' => $redirectLocale])
                ->willReturn('/' . $redirectLocale);
        } else {
            $this->urlGenerator->expects(static::never())->method('generate');
        }

        ($this->listener)($event);

        $response = $event->getResponse();

        if (null !== $redirectLocale) {
            static::assertInstanceOf(RedirectResponse::class, $response);
        }

        static::assertCount(1, $response->headers->getCookies());
    }

    /**
     * @return iterable<array{0: Request, 1?: string}>
     */
    public static function provideRequestsAndRedirects(): iterable
    {
        yield 'it redirects to "ca" since it is the preferred language' => [
            Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5']),
            'ca',
        ];
        yield 'it redirect to "es" since it is the default language' => [
            Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5']),
            'es',
        ];
        yield 'it does not redirect if we are not on "/" homepage' => [
            Request::create('/random_page', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5']),
        ];

        $esRequest = Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5']);
        $esRequest->setLocale('es');

        yield 'it does not redirect to default language if we are already on it' => [$esRequest];

        $caRequest = Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'ca-es,ca;q=0.5']);
        $caRequest->setLocale('ca');

        yield 'it does not redirect to preferred language if we are already on it' => [$caRequest];
    }

    public function testItDoesNotRedirectIfLanguageCookieExists(): void
    {
        $response = new Response();
        $event = new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [self::COOKIE_NAME => true], [], [
                'HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5',
            ]),
            HttpKernelInterface::MAIN_REQUEST,
            $response
        );

        ($this->listener)($event);

        static::assertSame($response, $event->getResponse());
        static::assertCount(0, $event->getResponse()->headers->getCookies());
    }

    public function testItDoesNotRedirectIfSubRequest(): void
    {
        $response = new Response();
        $event = new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [], [], [
                'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5',
            ]),
            HttpKernelInterface::SUB_REQUEST,
            $response
        );

        ($this->listener)($event);

        static::assertSame($response, $event->getResponse());
        static::assertCount(0, $event->getResponse()->headers->getCookies());
    }

    public function testItDoesNotRedirectIfItIsACrawler(): void
    {
        $response = new Response();
        $event = new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            Request::create('/', 'GET', [], [], [], [
                'HTTP_USER_AGENT' => 'Googlebot',
                'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5',
            ]),
            HttpKernelInterface::MAIN_REQUEST,
            $response
        );

        ($this->listener)($event);

        static::assertSame($response, $event->getResponse());
        static::assertCount(0, $event->getResponse()->headers->getCookies());
    }
}
