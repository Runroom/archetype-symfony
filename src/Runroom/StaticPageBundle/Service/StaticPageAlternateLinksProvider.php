<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\BaseBundle\Service\AlternateLinks\AbstractAlternateLinksProvider;

class StaticPageAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getRouteParameters($model, string $locale): array
    {
        return [
            'slug' => $model->getStaticPage()->translate($locale)->getSlug(),
        ];
    }

    protected function getRoutes(): array
    {
        return ['runroom.static_page.route.static'];
    }
}
