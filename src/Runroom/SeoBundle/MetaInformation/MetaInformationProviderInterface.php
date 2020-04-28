<?php

namespace Runroom\SeoBundle\MetaInformation;

use Runroom\SeoBundle\Entity\EntityMetaInformation;
use Sonata\MediaBundle\Model\MediaInterface;

interface MetaInformationProviderInterface
{
    public function providesMetas(string $route): bool;

    public function getRouteAlias(string $route): string;

    public function getPlaceholders($model): array;

    public function getEntityMetaInformation($model): ?EntityMetaInformation;

    public function getEntityMetaImage($model): ?MediaInterface;
}
