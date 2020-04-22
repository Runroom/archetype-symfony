<?php

namespace Runroom\BaseBundle\Service\MetaInformation;

use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MetaInformationService implements EventSubscriberInterface
{
    protected $requestStack;
    protected $providers;
    protected $defaultProvider;
    protected $builder;

    public function __construct(
        RequestStack $requestStack,
        iterable $providers,
        DefaultMetaInformationProvider $defaultProvider,
        MetaInformationBuilder $builder
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

        $metas = $this->builder->build(
            $this->selectProvider($route),
            $route,
            $page->getContent()
        );

        $page->addContext('metas', $metas);

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

    protected function selectProvider(string $route): MetaInformationProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->providesMetas($route)) {
                return $provider;
            }
        }

        return $this->defaultProvider;
    }
}
