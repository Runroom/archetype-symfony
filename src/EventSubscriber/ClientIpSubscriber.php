<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ClientIpSubscriber implements EventSubscriberInterface
{
    protected const COOKIE_NAME = 'client_ip';

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (null === $request->cookies->get(self::COOKIE_NAME)) {
            $response = $event->getResponse();

            $response->headers->setCookie(
                Cookie::create(self::COOKIE_NAME, $request->getClientIp(), 0, '/', null, true, false)
            );
            $response->setPrivate();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
