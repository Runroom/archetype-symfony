<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Repository\MetaInformationRepository;

abstract class AbstractMetaInformationProvider implements MetaInformationProviderInterface
{
    protected static $routes = [];
    protected static $aliases = [];
    protected $repository;

    public function __construct(MetaInformationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function providesMetas(string $route): bool
    {
        return in_array($route, static::$routes);
    }

    public function findMetasFor(string $route, $model): MetaInformation
    {
        $metas = $this->repository->findOneByRoute($this->getRouteAlias($route));

        $metas->setTitle($this->getMetaTitle($metas, $model));
        $metas->setDescription($this->getMetaDescription($metas, $model));
        $metas->setImage($this->getMetaImage($metas, $model));

        return $metas;
    }

    protected function getRouteAlias(string $route): string
    {
        foreach (static::$aliases as $alias => $routes) {
            if (in_array($route, $routes, true)) {
                return $alias;
            }
        }

        return $route;
    }

    protected function getMetaTitle(MetaInformation $metas, $model): string
    {
        $metaTitle = $this->getEntityMetaPropertyFromMethod($model, 'getTitle');

        if ($metaTitle) {
            return $metaTitle;
        }

        return $this->replacePlaceholders(
            $metas->getTitle(),
            $this->getPlaceholders($model)
        );
    }

    protected function getMetaDescription(MetaInformation $metas, $model): string
    {
        $metaDescription = $this->getEntityMetaPropertyFromMethod($model, 'getDescription');

        if ($metaDescription) {
            return $metaDescription;
        }

        return $this->replacePlaceholders(
            $metas->getDescription(),
            $this->getPlaceholders($model)
        );
    }

    protected function getMetaImage(MetaInformation $metas, $model)
    {
        $image = $this->getModelMetaImage($model);

        return $image ?: $metas->getImage();
    }

    protected function getEntityMetaInformation($model)
    {
    }

    abstract protected function getPlaceholders($model): array;

    abstract protected function getModelMetaImage($model);

    private function replacePlaceholders(string $property, array $placeholders): string
    {
        return str_replace(array_keys($placeholders), array_values($placeholders), $property);
    }

    private function getEntityMetaPropertyFromMethod($model, string $method): ?string
    {
        $metaInformation = $this->getEntityMetaInformation($model);

        if (method_exists($metaInformation, $method)) {
            $metaProperty = $metaInformation->$method();
            if (!empty($metaProperty)) {
                return $metaProperty;
            }
        }
        return null;
    }
}
