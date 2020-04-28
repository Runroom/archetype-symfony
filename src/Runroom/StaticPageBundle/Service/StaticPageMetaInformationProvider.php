<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\SeoBundle\Entity\EntityMetaInformation;
use Runroom\SeoBundle\MetaInformation\AbstractMetaInformationProvider;

class StaticPageMetaInformationProvider extends AbstractMetaInformationProvider
{
    public function getEntityMetaInformation($model): ?EntityMetaInformation
    {
        return $model->getStaticPage()->getMetaInformation();
    }

    public function getPlaceholders($model): array
    {
        return [
            '{title}' => $model->getStaticPage()->getTitle(),
            '{content}' => $model->getStaticPage()->getContent(),
        ];
    }

    protected function getRoutes(): array
    {
        return ['runroom.static_page.route.static'];
    }
}
