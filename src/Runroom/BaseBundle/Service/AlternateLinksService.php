<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService
{
    protected $providers;
    protected $request_stack;

    public function __construct(
        array $providers,
        RequestStack $request_stack
    ) {
        $this->providers = $providers;
        $this->request_stack = $request_stack;
    }

    public function findAlternateLinksFor($route, $model)
    {
        $base_route = substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesAlternateLinks($base_route)) {
                return $provider->findAlternateLinksFor($base_route, $model);
            }
        }
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
