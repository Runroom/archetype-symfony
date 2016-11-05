<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Service\MetaInformationProvider\MetaInformationProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MetaInformationService
{
    protected $request_stack;
    protected $default_provider;
    protected $providers;

    public function __construct(
        RequestStack $request_stack,
        MetaInformationProviderInterface $default_provider
    ) {
        $this->request_stack = $request_stack;
        $this->default_provider = $default_provider;
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

        return $this->default_provider->findMetasFor($route, $model);
    }

    public function onPageEvent(PageEvent $event)
    {
        $request = $this->request_stack->getCurrentRequest();
        $route = $request->get('_route');

        $page = $event->getPage();

        $model = $page->getContent();
        $metas = $this->findMetasFor($route, $model);
        $page->setMetas($metas);

        $event->setPage($page);
    }
}
