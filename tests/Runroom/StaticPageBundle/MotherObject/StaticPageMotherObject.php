<?php

namespace Tests\Runroom\StaticPageBundle\MotherObject;

use Runroom\StaticPageBundle\Entity\StaticPage;

class StaticPageMotherObject
{
    const ID = 1;
    const TITLE = 'title';
    const CONTENT = 'content';
    const LOCATION = 'none';
    const SLUG = 'slug';
    const PUBLISH = true;
    const META_INFORMATION = null;

    public static function create(): StaticPage
    {
        return new StaticPage();
    }

    public static function createWithTitleAndContent($title, $content): StaticPage
    {
        $staticPage = new StaticPage();

        $staticPage->translate()->setTitle($title);
        $staticPage->translate()->setContent($content);

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

    public static function createFilled()
    {
        $staticPage = new StaticPage();

        $staticPage->setId(self::ID);
        $staticPage->translate()->setTitle(self::TITLE);
        $staticPage->translate()->setContent(self::CONTENT);
        $staticPage->translate()->setSlug(self::SLUG);
        $staticPage->setPublish(self::PUBLISH);
        $staticPage->setMetaInformation(self::META_INFORMATION);

        return $staticPage;
    }
}
