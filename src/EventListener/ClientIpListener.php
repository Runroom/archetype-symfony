<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

#[AsEventListener]
final class ClientIpListener
{
    /**
     * @var string
     */
    private const COOKIE_NAME = 'client_ip';

    public function __invoke(ResponseEvent $event): void
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
}
