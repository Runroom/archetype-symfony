<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

class DefaultAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function providesAlternateLinks(string $route): bool
    {
        return true;
    }

    public function getRouteParameters($model, string $locale): array
    {
        return [];
    }
}
