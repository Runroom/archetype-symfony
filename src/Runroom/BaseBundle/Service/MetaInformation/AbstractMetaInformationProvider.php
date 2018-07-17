<?php

namespace Runroom\BaseBundle\Service\MetaInformation;

use Runroom\BaseBundle\Entity\EntityMetaInformation;
use Runroom\BaseBundle\Entity\Media;

abstract class AbstractMetaInformationProvider implements MetaInformationProviderInterface
{
    public function providesMetas(string $route): bool
    {
        return \in_array($route, $this->getRoutes(), true);
    }

    public function getRouteAlias(string $route): string
    {
        foreach ($this->getRouteAliases() as $alias => $routes) {
            if (\in_array($route, $routes, true)) {
                return $alias;
            }
        }

        return $route;
    }

    public function getPlaceholders($model): array
    {
        return [];
    }

    public function getEntityMetaInformation($model): ?EntityMetaInformation
    {
        return null;
    }

    public function getEntityMetaImage($model): ?Media
    {
        return null;
    }

    protected function getRouteAliases(): array
    {
        return [];
    }

    abstract protected function getRoutes(): array;
}
