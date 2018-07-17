<?php

namespace Runroom\BaseBundle\Service\MetaInformation;

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
