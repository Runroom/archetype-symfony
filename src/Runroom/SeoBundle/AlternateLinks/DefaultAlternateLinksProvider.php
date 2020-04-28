<?php

namespace Runroom\SeoBundle\AlternateLinks;

class DefaultAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function providesAlternateLinks(string $route): bool
    {
        return true;
    }

    public function getParameters($model, string $locale): ?array
    {
        return null;
    }

    protected function getRoutes(): array
    {
        return [];
    }
}
