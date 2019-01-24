<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\BaseBundle\Service\AlternateLinksProvider\AbstractAlternateLinksProvider;

class StaticPageAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    protected static $routes = ['runroom.static_page.route.static'];

    public function getRouteParameters($model, string $locale): array
    {
        return [
            'slug' => $model->getStaticPage()->translate($locale)->getSlug(),
        ];
    }
}
