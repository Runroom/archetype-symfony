<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Service\MetaInformationProvider\DefaultMetaInformationProvider;
use Symfony\Component\HttpFoundation\RequestStack;

class MetaInformationService
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

    public function onPageEvent(PageEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route', '');

        $page = $event->getPage();

        $model = $page->getContent();
        $metas = $this->findMetasFor($route, $model);
        $page->setMetas($metas);

        $event->setPage($page);
    }
}
