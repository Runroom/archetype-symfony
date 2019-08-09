<?php

namespace Tests\Runroom\BaseBundle\Unit;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\EventSubscriber\LanguageSwitchSubscriber;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class LanguageSwitchListenerTest extends TestCase
{
    const COOKIE_NAME = 'language_switched';
    const LOCALES = ['en', 'es', 'ca'];

    protected $requestStack;
    protected $PageRenderEvent;
    protected $subscriber;

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->PageRenderEvent = $this->prophesize(PageRenderEvent::class);

        $this->subscriber = new LanguageSwitchSubscriber(
            $this->requestStack->reveal(),
            new CrawlerDetect(),
            self::LOCALES
        );
    }

    /**
     * @test
     */
    public function itRedirectsToBrowserLanguage()
    {
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5']);

        $pageViewModel = $this->prophesize(PageViewModel::class);
        $pageViewModel->getAlternateLinks()->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->requestStack->getCurrentRequest()->willReturn($request);

        $this->PageRenderEvent->getPageViewModel()->willReturn($pageViewModel->reveal());
        $this->PageRenderEvent->getResponse()->willReturn(new Response());
        $this->PageRenderEvent->setResponse(Argument::which('getTargetUrl', '/es'))->shouldBeCalled();
        $this->PageRenderEvent->stopPropagation()->shouldBeCalled();

        $this->subscriber->onPageRender($this->PageRenderEvent->reveal());
    }

    /**
     * @test
     */
    public function itRedirectsToSecondBrowserLanguage()
    {
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'fr-fr,fr;q=0.5, ca-es,ca;q=0.5']);

        $pageViewModel = $this->prophesize(PageViewModel::class);
        $pageViewModel->getAlternateLinks()->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->requestStack->getCurrentRequest()->willReturn($request);

        $this->PageRenderEvent->getPageViewModel()->willReturn($pageViewModel->reveal());
        $this->PageRenderEvent->getResponse()->willReturn(new Response());
        $this->PageRenderEvent->setResponse(Argument::which('getTargetUrl', '/ca'))->shouldBeCalled();
        $this->PageRenderEvent->stopPropagation()->shouldBeCalled();

        $this->subscriber->onPageRender($this->PageRenderEvent->reveal());
    }

    /**
     * @test
     */
    public function itDoesNotRedirectIfLanguageIsNotAvailable()
    {
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_ACCEPT_LANGUAGE' => 'fr-ca,fr;q=0.5']);
        $response = new Response();

        $pageViewModel = $this->prophesize(PageViewModel::class);
        $pageViewModel->getAlternateLinks()->willReturn([
            'en' => '/',
            'es' => '/es',
            'ca' => '/ca',
        ]);

        $this->requestStack->getCurrentRequest()->willReturn($request);

        $this->PageRenderEvent->getPageViewModel()->willReturn($pageViewModel->reveal());
        $this->PageRenderEvent->getResponse()->willReturn($response);
        $this->PageRenderEvent->setResponse(Argument::exact($response))->shouldBeCalled();
        $this->PageRenderEvent->stopPropagation()->shouldNotBeCalled();

        $this->subscriber->onPageRender($this->PageRenderEvent->reveal());
    }

    /**
     * @test
     */
    public function itDoesNotRedirectIfLanguageCookieExists()
    {
        $request = Request::create('/', 'GET', [],
            [self::COOKIE_NAME => true], [], ['HTTP_ACCEPT_LANGUAGE' => 'es-es,es;q=0.5']);

        $this->requestStack->getCurrentRequest()->willReturn($request);

        $this->PageRenderEvent->setResponse(Argument::any())->shouldNotBeCalled();

        $this->subscriber->onPageRender($this->PageRenderEvent->reveal());
    }
}
