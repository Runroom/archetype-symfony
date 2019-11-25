<?php

namespace Runroom\StaticPageBundle\Service;

use Runroom\BaseBundle\Service\AlternateLinks\AbstractAlternateLinksProvider;

class StaticPageAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getAvailableLocales($model): ?array
    {
        return $model->getStaticPage()->getTranslations()->getKeys();
    }

    public function getParameters($model, string $locale): array
    {
        return [
            'slug' => $model->getStaticPage()->getSlug($locale),
        ];
    }

    protected function getRoutes(): array
    {
        return ['runroom.static_page.route.static'];
    }
}
