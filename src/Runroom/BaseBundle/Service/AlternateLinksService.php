<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\Event\PageEvent;
use Runroom\BaseBundle\Service\AlternateLinksProvider\AlternateLinksProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AlternateLinksService
{
    protected $requestStack;
    protected $defaultProvider;
    protected $providers;

    public function __construct(
        RequestStack $requestStack,
        iterable $providers,
        AlternateLinksProviderInterface $defaultProvider
    ) {
        $this->requestStack = $requestStack;
        $this->providers = $providers;
        $this->defaultProvider = $defaultProvider;
    }

    public function findAlternateLinksFor(string $route, $model): array
    {
        $route = empty($route) ? '' : \substr($route, 0, -3);

        foreach ($this->providers as $provider) {
            if ($provider->providesAlternateLinks($route)) {
                return $provider->findAlternateLinksFor($route, $model);
            }
        }

        return $this->defaultProvider->findAlternateLinksFor($route, $model);
    }

    public function onPageEvent(PageEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->get('_route', '');

        $page = $event->getPage();

        $model = $page->getContent();
        $alternateLinks = $this->findAlternateLinksFor($route, $model);
        $page->setAlternateLinks($alternateLinks);

        $event->setPage($page);
    }
}
