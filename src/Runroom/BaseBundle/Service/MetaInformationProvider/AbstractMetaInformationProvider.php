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

    public function providesMetas($meta_route)
    {
        return in_array($meta_route, static::$routes);
    }

    public function findMetasFor($meta_route, $model)
    {
        $metas = $this->repository->findOneByRoute($meta_route);

        $metas->setTitle($this->getMetaTitle($metas, $model));
        $metas->setDescription($this->getMetaDescription($metas, $model));
        $metas->setImage($this->getMetaImage($metas, $model));

        return $metas;
    }

    protected function getMetaTitle($metas, $model)
    {
        $meta_information_title = $this->getEntityMetaPropertyFromMethod($model, 'getTitle');

        if ($meta_information_title) {
            return $meta_information_title;
        }

        return $this->replacePlaceholders(
            $metas->getTitle(),
            $this->getMetaTitlePlaceholders($model)
        );
    }

    protected function getMetaDescription($metas, $model)
    {
        $meta_information_description = $this->getEntityMetaPropertyFromMethod($model, 'getDescription');

        if ($meta_information_description) {
            return $meta_information_description;
        }

        return $this->replacePlaceholders(
            $metas->getDescription(),
            $this->getMetaDescriptionPlaceholders($model)
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

    abstract protected function getMetaTitlePlaceholders($model);
    abstract protected function getMetaDescriptionPlaceholders($model);
    abstract protected function getModelMetaImage($model);

    private function replacePlaceholders($property, $placeholders)
    {
        foreach ($placeholders as $placeholder => $value) {
            $property = str_replace($placeholder, $value, $property);
        }

        return $property;
    }

    private function getEntityMetaPropertyFromMethod($model, $method)
    {
        $entity_meta_information = $this->getEntityMetaInformation($model);

        if (method_exists($entity_meta_information, $method)) {
            $meta_information_property = $entity_meta_information->$method();
            if (!empty($meta_information_property)) {
                return $meta_information_property;
            }
        }
    }
}
