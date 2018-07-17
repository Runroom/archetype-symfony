<?php

namespace Runroom\BaseBundle\Service\MetaInformation;

use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\ViewModel\MetaInformationViewModel;
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
        $model = $page->getContent();

        $metas = $this->findMetasFor($route, $model);
        $page->setMetas($metas);

        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }

    protected function getCurrentRoute()
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route', '');

        return empty($route) ? '' : \substr($route, 0, -3);
    }

    protected function findMetasFor(string $route, $model): MetaInformationViewModel
    {
        $selectedProvider = $this->defaultProvider;

        foreach ($this->providers as $provider) {
            if ($provider->providesMetas($route)) {
                $selectedProvider = $provider;

                break;
            }
        }

        return $this->builder->build($selectedProvider, $route, $model);
    }
}
