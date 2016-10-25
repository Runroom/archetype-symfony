<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

class DefaultAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function providesAlternateLinks($base_route)
    {
        return true;
    }

    public function getRouteParameters($model, $locale)
    {
        return [];
    }
}
