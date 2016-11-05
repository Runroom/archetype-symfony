<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

class StaticPageMetaInformationProvider extends AbstractMetaInformationProvider
{
    public static $routes = [
        'runroom.base.route.static',
    ];

    protected function getEntityMetaInformation($model)
    {
        return $model->getStaticPage()->getMetaInformation();
    }

    protected function getMetaTitlePlaceholders($model)
    {
        return [
            '{title}' => $model->getStaticPage()->getTitle(),
        ];
    }

    protected function getMetaDescriptionPlaceholders($model)
    {
        return [
            '{content}' => $model->getStaticPage()->getContent(),
        ];
    }

    protected function getModelMetaImage($model)
    {
    }
}
