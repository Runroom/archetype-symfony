<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService implements EventSubscriberInterface
{
    protected const EXCLUDED_PARAMETERS = ['_locale', '_fragment'];
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
            $page->getContent(),
            $route,
            $this->getCurrentRouteParameters()
        );

        $page->addContext('alternate_links', $alternateLinks);

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

        return $request->get('_route', '');
    }

    protected function getCurrentRouteParameters(): array
    {
        $request = $this->requestStack->getCurrentRequest();

        $routeParameters = $request->get('_route_params', []);

        return \array_diff_key($routeParameters, \array_flip(self::EXCLUDED_PARAMETERS));
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
