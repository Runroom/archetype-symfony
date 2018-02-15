<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\Service\AlternateLinksProvider\DefaultAlternateLinksProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService implements EventSubscriberInterface
{
    protected $requestStack;
    protected $defaultProvider;
    protected $providers;

    public function __construct(
        RequestStack $requestStack,
        iterable $providers,
        DefaultAlternateLinksProvider $defaultProvider
    ) {
        $this->requestStack = $requestStack;
        $this->providers = $providers;
        $this->defaultProvider = $defaultProvider;
    }

    public function findAlternateLinksFor(string $route, $model): array
    {
        $route = empty($route) ? '' : \substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesAlternateLinks($route)) {
                return $provider->findAlternateLinksFor($route, $model);
            }
        }

        return $this->defaultProvider->findAlternateLinksFor($route, $model);
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route', '');

        $page = $event->getPageViewModel();

        $model = $page->getContent();
        $alternateLinks = $this->findAlternateLinksFor($route, $model);
        $page->setAlternateLinks($alternateLinks);

        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }
}
