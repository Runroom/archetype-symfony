<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Service\AlternateLinksProvider\AlternateLinksProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService
{
    protected $requestStack;
    protected $defaultProvider;
    protected $providers = [];

    public function __construct(
        RequestStack $requestStack,
        AlternateLinksProviderInterface $defaultProvider
    ) {
        $this->request_stack = $requestStack;
        $this->defaultProvider = $defaultProvider;
    }

    public function addProvider(AlternateLinksProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function findAlternateLinksFor(string $route, $model): array
    {
        $route = empty($route) ? '' : substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesAlternateLinks($route)) {
                return $provider->findAlternateLinksFor($route, $model);
            }
        }

        return $this->defaultProvider->findAlternateLinksFor($route, $model);
    }

    public function onPageEvent(PageEvent $event)
    {
        $request = $this->request_stack->getCurrentRequest();
        $route = $request->get('_route', '');

        $page = $event->getPage();

        $model = $page->getContent();
        $alternateLinks = $this->findAlternateLinksFor($route, $model);
        $page->setAlternateLinks($alternateLinks);

        $event->setPage($page);
    }
}
