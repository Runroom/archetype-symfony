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

    abstract public function getParameters($model, string $locale): ?array;

    abstract protected function getRoutes(): array;
}
