<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

abstract class AbstractAlternateLinksProvider implements AlternateLinksProviderInterface
{
    public function providesAlternateLinks(string $route): bool
    {
        return \in_array($route, $this->getRoutes(), true);
    }

    public function getAvailableLocales($model): ?array
    {
        return null;
    }

    public function getParameters($model, string $locale): ?array
    {
        return null;
    }

    abstract protected function getRoutes(): array;
}
