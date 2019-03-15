<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\Service\InternalIpService;
use Runroom\BaseBundle\ViewModel\PageViewModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class InternalIpServiceServiceTest extends TestCase
{
    const INTERNAL_IPS = ['127.0.0.1', '/192\.168\.33\..*/'];

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);

        $this->service = new InternalIpService(
            self::INTERNAL_IPS,
            $this->requestStack->reveal()
        );
    }

    /**
     * @dataProvider ipProvider
     * @test
     */
    public function itChecksIp($ip, $isInternal)
    {
        $request = new Request([], [], [], [], [], ['REMOTE_ADDR' => $ip]);

        $this->requestStack->getCurrentRequest()->shouldBeCalled()->willReturn($request);

        $event = $this->configurePageRenderEvent();

        $this->service->onPageRender($event);

        $this->assertSame($isInternal, $event->getPageViewModel()->getIsInternalIp());
    }

    public function ipProvider()
    {
        return [
            ['1.1.1.1', false],
            ['192.168.33.1', true],
            ['192.168.33.10', true],
            ['192.168.32.10', false],
        ];
    }

    protected function configurePageRenderEvent(): PageRenderEvent
    {
        $response = $this->prophesize(Response::class);
        $page = new PageViewModel();

        return new PageRenderEvent('view', $page, $response->reveal());
    }
}
