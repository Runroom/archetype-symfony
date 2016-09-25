<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

class StaticPageAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    protected static $routes = ['runroom.base.route.static'];

    public function getRouteParameters($model, $locale)
    {
        return [
            'static_page_slug' => $model->getStaticPage()->translate($locale)->getSlug(),
        ];
    }
}
