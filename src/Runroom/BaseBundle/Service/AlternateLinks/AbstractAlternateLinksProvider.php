<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

abstract class AbstractAlternateLinksProvider implements AlternateLinksProviderInterface
{
    public function providesAlternateLinks(string $route): bool
    {
        return \in_array($route, $this->getRoutes(), true);
    }

    public function getRouteParameters($model, string $locale): array
    {
        return [];
    }

    public function getQueryParameters($model, string $locale): array
    {
        return [];
    }

    abstract protected function getRoutes(): array;
}
