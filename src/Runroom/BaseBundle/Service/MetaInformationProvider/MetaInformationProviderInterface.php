<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

use Runroom\BaseBundle\Entity\MetaInformation;

interface MetaInformationProviderInterface
{
    public function providesMetas(string $route): bool;
    public function findMetasFor(string $route, $model): MetaInformation;
}
