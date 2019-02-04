<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

class DefaultAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function providesAlternateLinks(string $route): bool
    {
        return true;
    }

    protected function getRoutes(): array
    {
        return [];
    }
}
