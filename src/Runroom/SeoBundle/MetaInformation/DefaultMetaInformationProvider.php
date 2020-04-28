<?php

namespace Runroom\SeoBundle\MetaInformation;

class DefaultMetaInformationProvider extends AbstractMetaInformationProvider
{
    public function providesMetas(string $route): bool
    {
        return true;
    }

    protected function getRoutes(): array
    {
        return [];
    }
}
