<?php

namespace Tests\Unit;

use App\EventSubscriber\LanguageSwitchSubscriber;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Runroom\RenderEventBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class LanguageSwitchSubscriberTest extends TestCase
{
    use ProphecyTrait;

    private const COOKIE_NAME = 'language_switched';
    private const LOCALES = ['en', 'es', 'ca'];

    /** @var RequestStack */
    private $requestStack;

    /** @var ObjectProphecy<PageRenderEvent> */
    private $pageRenderEvent;

    /** @var LanguageSwitchSubscriber */
    private $subscriber;

    protected function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $this->pageRenderEvent = $this->prophesize(PageRenderEvent::class);

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

        $pageViewModel = $this->prophesize(PageViewModel::class);
        $pageViewModel->getContext('alternate_links')->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->pageRenderEvent->getPageViewModel()->willReturn($pageViewModel->reveal());
        $this->pageRenderEvent->getResponse()->willReturn(new Response());
        $this->pageRenderEvent->setResponse(Argument::which('getTargetUrl', '/ca'))->shouldBeCalled();
        $this->pageRenderEvent->stopPropagation()->shouldBeCalled();

        $this->subscriber->onPageRender($this->pageRenderEvent->reveal());
    }

    /** @test */
    public function itDoesNotRedirectIfLanguageIsNotAvailable(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [], [], [
            'HTTP_ACCEPT_LANGUAGE' => 'fr-ca,fr;q=0.5',
        ]));

        $response = new Response();

        $pageViewModel = $this->prophesize(PageViewModel::class);
        $pageViewModel->getContext('alternate_links')->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->pageRenderEvent->getPageViewModel()->willReturn($pageViewModel->reveal());
        $this->pageRenderEvent->getResponse()->willReturn($response);
        $this->pageRenderEvent->setResponse(Argument::any())->shouldNotBeCalled();
        $this->pageRenderEvent->stopPropagation()->shouldNotBeCalled();

        $this->subscriber->onPageRender($this->pageRenderEvent->reveal());
    }

    /** @test */
    public function itDoesNotRedirectIfLanguageCookieExists(): void
    {
        $this->requestStack->push(Request::create('/', 'GET', [], [
            self::COOKIE_NAME => true,
        ], [], ['HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5']));

        $this->pageRenderEvent->setResponse(Argument::any())->shouldNotBeCalled();

        $this->subscriber->onPageRender($this->pageRenderEvent->reveal());
    }
}
