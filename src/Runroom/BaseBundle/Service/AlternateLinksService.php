<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Service\AlternateLinksProvider\AlternateLinksProviderInterface;
use Runroom\BaseBundle\Event\PageEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService
{
    protected $request_stack;
    protected $default_provider;
    protected $providers;

    public function __construct(
        RequestStack $request_stack,
        AlternateLinksProviderInterface $default_provider
    ) {
        $this->request_stack = $request_stack;
        $this->default_provider = $default_provider;
        $this->providers = [];
    }

    public function addProvider(AlternateLinksProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function findAlternateLinksFor($route, $model)
    {
        $route = substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesAlternateLinks($route)) {
                return $provider->findAlternateLinksFor($route, $model);
            }
        }
        return $this->default_provider->findAlternateLinksFor($route, $model);
    }

    public function onPageEvent(PageEvent $event)
    {
        $request = $this->request_stack->getCurrentRequest();
        $route = $request->get('_route');
        $page = $event->getPage();
        $model = $page->getContent();

        $alternate_links = $this->findAlternateLinksFor($route, $model);

        $page->setAlternateLinks($alternate_links);

        $event->setPage($page);
    }
}
