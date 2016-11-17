<?php

namespace Runroom\StaticPageBundle\Tests\MotherObject;

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

    public static function create()
    {
        return new StaticPage();
    }

    public static function createWithTitleAndContent($title, $content)
    {
        $static_page = new StaticPage();

        $static_page->setTitle($title);
        $static_page->setContent($content);

        return $static_page;
    }

    public static function createWithSlugs(array $locales)
    {
        $static_page = new StaticPage();

        foreach ($locales as $locale) {
            $static_page->translate($locale)->setSlug('slug_' . $locale);
        }

        return $static_page;
    }

    public static function createFilled()
    {
        $static_page = new StaticPage();

        $static_page->setId(self::ID);
        $static_page->setTitle(self::TITLE);
        $static_page->setContent(self::CONTENT);
        $static_page->setSlug(self::SLUG);
        $static_page->setPublish(self::PUBLISH);
        $static_page->setMetaInformation(self::META_INFORMATION);

        return $static_page;
    }
}
