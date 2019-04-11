<?php

namespace Tests\Runroom\RedirectionsBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\RedirectionsBundle\Listener\RedirectListener;
use Runroom\RedirectionsBundle\Repository\RedirectRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class RedirectListenerTest extends TestCase
{
    protected $repository;
    protected $listener;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(RedirectRepository::class);

        $this->listener = new RedirectListener($this->repository->reveal());
    }

    /**
     * @test
     */
    public function itSubscribesToKernelRequestEvent()
    {
        $events = $this->listener->getSubscribedEvents();

        $this->assertArrayHasKey(KernelEvents::REQUEST, $events);
    }

    /**
     * @test
     */
    public function itDoesNotDoAnythingIfTheRequestIsNotTheMasterOne()
    {
        $event = $this->getResponseEvent(HttpKernelInterface::SUB_REQUEST);

        $this->listener->onKernelRequest($event);

        $this->assertNull($event->getResponse());
    }

    /**
     * @test
     */
    public function itDoesNotDOAnythingIfTheRouteIsNotFoundOnTheRepository()
    {
        $this->repository->findRedirect('/')->shouldBeCalled()->willReturn(null);

        $event = $this->getResponseEvent();

        $this->listener->onKernelRequest($event);

        $this->assertNull($event->getResponse());
    }

    /**
     * @test
     */
    public function itDoesARedirectToDestinationUrl()
    {
        $this->repository->findRedirect('/')->shouldBeCalled()->willReturn([
            'destination' => '/redirect',
            'httpCode' => 301,
        ]);

        $event = $this->getResponseEvent();

        $this->listener->onKernelRequest($event);

        $response = $event->getResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame('/redirect', $response->getTargetUrl());
        $this->assertSame(301, $response->getStatusCode());
    }

    private function getResponseEvent(int $requestType = HttpKernelInterface::MASTER_REQUEST)
    {
        return new GetResponseEvent(
            new \AppKernel('test', false),
            new Request(),
            $requestType
        );
    }
}
