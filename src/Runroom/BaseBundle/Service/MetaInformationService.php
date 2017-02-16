<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Service\MetaInformationProvider\MetaInformationProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MetaInformationService
{
    protected $requestStack;
    protected $defaultProvider;
    protected $providers;

    public function __construct(
        RequestStack $requestStack,
        MetaInformationProviderInterface $defaultProvider
    ) {
        $this->requestStack = $requestStack;
        $this->defaultProvider = $defaultProvider;
        $this->providers = [];
    }

    public function addProvider(MetaInformationProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function findMetasFor($route, $model)
    {
        $route = empty($route) ? '' : substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesMetas($route)) {
                return $provider->findMetasFor($route, $model);
            }
        }

        return $this->defaultProvider->findMetasFor($route, $model);
    }

    public function onPageEvent(PageEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route');

        $page = $event->getPage();

        $model = $page->getContent();
        $metas = $this->findMetasFor($route, $model);
        $page->setMetas($metas);

        $event->setPage($page);
    }
}
