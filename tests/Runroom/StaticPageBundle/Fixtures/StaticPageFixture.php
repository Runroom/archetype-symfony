<?php

namespace Tests\Runroom\StaticPageBundle\Fixtures;

use Runroom\StaticPageBundle\Entity\StaticPage;
use Tests\Runroom\SeoBundle\Fixtures\EntityMetaInformationFixture;

class StaticPageFixture
{
    public const ID = 1;
    public const TITLE = 'title';
    public const CONTENT = 'content';
    public const LOCATION = 'none';
    public const SLUG = 'slug';
    public const PUBLISH = true;

    public static function create()
    {
        $staticPage = new StaticPage();

        $staticPage->setId(self::ID);
        $staticPage->setLocation(self::LOCATION);
        $staticPage->translate()->setTitle(self::TITLE);
        $staticPage->translate()->setContent(self::CONTENT);
        $staticPage->translate()->setSlug(self::SLUG);
        $staticPage->setPublish(self::PUBLISH);
        $staticPage->setMetaInformation(EntityMetaInformationFixture::create());

        return $staticPage;
    }

    public static function createWithSlugs(array $locales)
    {
        $staticPage = new StaticPage();

        foreach ($locales as $locale) {
            $staticPage->translate($locale)->setSlug('slug_' . $locale);
        }

        return $staticPage;
    }
}
