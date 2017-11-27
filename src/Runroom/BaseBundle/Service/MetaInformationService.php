<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\BaseBundle\Service\MetaInformationProvider\DefaultMetaInformationProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MetaInformationService implements EventSubscriberInterface
{
    protected $requestStack;
    protected $defaultProvider;
    protected $providers;

    public function __construct(
        RequestStack $requestStack,
        iterable $providers,
        DefaultMetaInformationProvider $defaultProvider
    ) {
        $this->requestStack = $requestStack;
        $this->providers = $providers;
        $this->defaultProvider = $defaultProvider;
    }

    public function findMetasFor(string $route, $model): MetaInformation
    {
        $route = empty($route) ? '' : \substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesMetas($route)) {
                return $provider->findMetasFor($route, $model);
            }
        }

        return $this->defaultProvider->findMetasFor($route, $model);
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route', '');

        $page = $event->getPage();

        $model = $page->getContent();
        $metas = $this->findMetasFor($route, $model);
        $page->setMetas($metas);

        $event->setPage($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }
}
