<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\EventSubscriber\LanguageSwitchSubscriber;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Runroom\RenderEventBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class LanguageSwitchSubscriberTest extends TestCase
{
    private const COOKIE_NAME = 'language_switched';
    private const LOCALES = ['en', 'es', 'ca'];

    /** @var RequestStack */
    private $requestStack;

    /** @var MockObject&PageRenderEvent */
    private $pageRenderEvent;

    /** @var LanguageSwitchSubscriber */
    private $subscriber;

    protected function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $this->pageRenderEvent = $this->createMock(PageRenderEvent::class);

        $this->subscriber = new LanguageSwitchSubscriber(
            $this->requestStack,
            new CrawlerDetect(),
            self::LOCALES
        );
    }

    /** @test */
    public function itRedirectsToBrowserLanguage(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5',
        ]));

        $pageViewModel = $this->createMock(PageViewModel::class);
        $pageViewModel->method('getContext')->with('alternate_links')->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->pageRenderEvent->method('getPageViewModel')->willReturn($pageViewModel);
        $this->pageRenderEvent->method('getResponse')->willReturn(new Response());
        $this->pageRenderEvent->expects($this->once())->method('setResponse')->with($this->isInstanceOf(RedirectResponse::class));
        $this->pageRenderEvent->expects($this->once())->method('stopPropagation');

        $this->subscriber->onPageRender($this->pageRenderEvent);
    }

    /** @test */
    public function itDoesNotRedirectIfLanguageIsNotAvailable(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_LANGUAGE' => 'fr-ca,fr;q=0.5',
        ]));

        $response = new Response();

        $pageViewModel = $this->createMock(PageViewModel::class);
        $pageViewModel->method('getContext')->with('alternate_links')->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->pageRenderEvent->method('getPageViewModel')->willReturn($pageViewModel);
        $this->pageRenderEvent->method('getResponse')->willReturn($response);
        $this->pageRenderEvent->expects($this->never())->method('setResponse');
        $this->pageRenderEvent->expects($this->never())->method('stopPropagation');

        $this->subscriber->onPageRender($this->pageRenderEvent);
    }

    /** @test */
    public function itDoesNotRedirectIfLanguageCookieExists(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [
            self::COOKIE_NAME => true,
        ], [], ['HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5']));

        $this->pageRenderEvent->expects($this->never())->method('setResponse');

        $this->subscriber->onPageRender($this->pageRenderEvent);
    }
}
