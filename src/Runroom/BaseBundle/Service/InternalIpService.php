<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class InternalIpService implements EventSubscriberInterface
{
    protected $internalIps;
    protected $requestStack;

    public function __construct(
        array $internalIps,
        RequestStack $requestStack
    ) {
        $this->internalIps = $internalIps;
        $this->requestStack = $requestStack;
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $page = $event->getPageViewModel();
        $page->setIsInternalIp($this->isInternalIp());
        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }

    protected function isInternalIp(): bool
    {
        $clientIp = $this->requestStack->getCurrentRequest()->getClientIp();

        foreach ($this->internalIps as $internalIp) {
            if ($this->checkInternalIp($internalIp, $clientIp)) {
                return true;
            }
        }

        return false;
    }

    protected function checkInternalIp($internalIp, $clientIp)
    {
        if (\preg_match('/\/.*\//', $internalIp)) {
            return \preg_match($internalIp, $clientIp);
        }

        return $clientIp === $internalIp;
    }
}
