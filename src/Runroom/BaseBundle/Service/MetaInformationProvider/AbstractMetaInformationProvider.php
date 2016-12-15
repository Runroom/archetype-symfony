<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

use Runroom\BaseBundle\Repository\MetaInformationRepository;

abstract class AbstractMetaInformationProvider implements MetaInformationProviderInterface
{
    protected static $routes = [];
    protected $repository;

    public function __construct(MetaInformationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function providesMetas($route)
    {
        return in_array($route, static::$routes);
    }

    public function findMetasFor($route, $model)
    {
        $metas = $this->repository->findOneByRoute($route);

        $metas->setTitle($this->getMetaTitle($metas, $model));
        $metas->setDescription($this->getMetaDescription($metas, $model));
        $metas->setImage($this->getMetaImage($metas, $model));

        return $metas;
    }

    protected function getMetaTitle($metas, $model)
    {
        $meta_title = $this->getEntityMetaPropertyFromMethod($model, 'getTitle');

        if ($meta_title) {
            return $meta_title;
        }

        return $this->replacePlaceholders(
            $metas->getTitle(),
            $this->getPlaceholders($model)
        );
    }

    protected function getMetaDescription($metas, $model)
    {
        $meta_description = $this->getEntityMetaPropertyFromMethod($model, 'getDescription');

        if ($meta_description) {
            return $meta_description;
        }

        return $this->replacePlaceholders(
            $metas->getDescription(),
            $this->getPlaceholders($model)
        );
    }

    protected function getMetaImage($metas, $model)
    {
        $image = $this->getModelMetaImage($model);

        return $image ?: $metas->getImage();
    }

    protected function getEntityMetaInformation($model)
    {
    }

    abstract protected function getPlaceholders($model);

    abstract protected function getModelMetaImage($model);

    private function replacePlaceholders($property, $placeholders)
    {
        return str_replace(array_keys($placeholders), array_values($placeholders), $property);
    }

    private function getEntityMetaPropertyFromMethod($model, $method)
    {
        $meta_information = $this->getEntityMetaInformation($model);

        if (method_exists($meta_information, $method)) {
            $meta_property = $meta_information->$method();
            if (!empty($meta_property)) {
                return $meta_property;
            }
        }
    }
}
