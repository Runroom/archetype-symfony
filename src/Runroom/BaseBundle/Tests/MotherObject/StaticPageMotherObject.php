<?php

namespace Runroom\BaseBundle\Tests\MotherObject;

use Runroom\BaseBundle\Entity\StaticPage;

class StaticPageMotherObject
{
    const ID = 1;
    const TITLE = 'title';
    const CONTENT = 'content';
    const BREADCRUMB = 'breadcrumb';
    const LOCATION = 'none';
    const SLUG = 'slug';
    const PUBLISH = true;
    const POSITION = 1;
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
        $static_page->setBreadcrumb(self::BREADCRUMB);
        $static_page->setLocation(self::LOCATION);
        $static_page->setSlug(self::SLUG);
        $static_page->setPosition(self::POSITION);
        $static_page->setPublish(self::PUBLISH);
        $static_page->setMetaInformation(self::META_INFORMATION);

        return $static_page;
    }
}
