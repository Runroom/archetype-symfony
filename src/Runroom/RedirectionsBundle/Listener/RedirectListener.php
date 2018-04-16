<?php

namespace Runroom\RedirectionsBundle\Listener;

use Runroom\RedirectionsBundle\Repository\RedirectRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RedirectListener implements EventSubscriberInterface
{
    protected $repository;

    public function __construct(RedirectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($redirect = $this->repository->findRedirect($event->getRequest()->getPathInfo())) {
            $event->setResponse(
                new RedirectResponse($redirect['destination'], $redirect['httpCode'])
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
