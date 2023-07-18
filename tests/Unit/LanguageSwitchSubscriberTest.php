<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\EventSubscriber\LanguageSwitchSubscriber;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\TestCase;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Runroom\RenderEventBundle\ViewModel\PageViewModelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class LanguageSwitchSubscriberTest extends TestCase
{
    /**
     * @var string
     */
    private const COOKIE_NAME = 'language_switched';

    /**
     * @var string[]
     */
    private const LOCALES = ['en', 'es', 'ca'];

    private RequestStack $requestStack;
    private PageRenderEvent $pageRenderEvent;
    private LanguageSwitchSubscriber $subscriber;

    protected function setUp(): void
    {
        $pageViewModel = $this->createMock(PageViewModelInterface::class);
        $pageViewModel->method('getContext')->with('alternate_links')->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->requestStack = new RequestStack();
        $this->pageRenderEvent = new PageRenderEvent('', $pageViewModel);

        $this->subscriber = new LanguageSwitchSubscriber(
            $this->requestStack,
            new CrawlerDetect(),
            self::LOCALES
        );
    }

    public function testItRedirectsToBrowserLanguage(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5',
        ]));

        $this->subscriber->onPageRender($this->pageRenderEvent);

        static::assertTrue($this->pageRenderEvent->isPropagationStopped());
        static::assertInstanceOf(RedirectResponse::class, $this->pageRenderEvent->getResponse());
    }

    public function testItDoesNotRedirectIfLanguageIsNotAvailable(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_LANGUAGE' => 'fr-ca,fr;q=0.5',
        ]));

        $this->subscriber->onPageRender($this->pageRenderEvent);

        static::assertFalse($this->pageRenderEvent->isPropagationStopped());
        static::assertNull($this->pageRenderEvent->getResponse());
    }

    public function testItDoesNotRedirectIfLanguageCookieExists(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [
            self::COOKIE_NAME => true,
        ], [], ['HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5']));

        $this->subscriber->onPageRender($this->pageRenderEvent);

        static::assertNull($this->pageRenderEvent->getResponse());
    }
}
