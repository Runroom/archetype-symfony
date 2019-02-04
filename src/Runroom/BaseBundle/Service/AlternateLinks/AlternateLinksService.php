<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

use Runroom\BaseBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService implements EventSubscriberInterface
{
    protected $requestStack;
    protected $defaultProvider;
    protected $providers;
    protected $builder;

    public function __construct(
        RequestStack $requestStack,
        iterable $providers,
        DefaultAlternateLinksProvider $defaultProvider,
        AlternateLinksBuilder $builder
    ) {
        $this->requestStack = $requestStack;
        $this->providers = $providers;
        $this->defaultProvider = $defaultProvider;
        $this->builder = $builder;
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $page = $event->getPageViewModel();
        $route = $this->getCurrentRoute();

        $alternateLinks = $this->builder->build(
            $this->selectProvider($route),
            $route,
            $page->getContent()
        );

        $page->setAlternateLinks($alternateLinks);

        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }

    protected function getCurrentRoute(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route', '');

        return empty($route) ? '' : \substr($route, 0, -3);
    }

    protected function selectProvider(string $route): AlternateLinksProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->providesAlternateLinks($route)) {
                return $provider;
            }
        }

        return $this->defaultProvider;
    }
}
