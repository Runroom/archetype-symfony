<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Service\MetaInformationProvider\MetaInformationProviderInterface;
use Runroom\BaseBundle\Event\PageEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class MetaInformationService
{
    protected $providers;
    protected $request_stack;

    public function __construct(
        RequestStack $request_stack
    ) {
        $this->request_stack = $request_stack;
        $this->providers = [];
    }

    public function addProvider(MetaInformationProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function findMetasFor($route, $model)
    {
        $meta_route = substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesMetas($meta_route)) {
                return $provider->findMetasFor($meta_route, $model);
            }
        }
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
