<?php

namespace Runroom\BaseBundle\Service\MetaInformation;

use Runroom\BaseBundle\Entity\EntityMetaInformation;
use Runroom\BaseBundle\Entity\Media;

interface MetaInformationProviderInterface
{
    public function providesMetas(string $route): bool;

    public function getRouteAlias(string $route): string;

    public function getPlaceholders($model): array;

    public function getEntityMetaInformation($model): ?EntityMetaInformation;

    public function getEntityMetaImage($model): ?Media;
}
