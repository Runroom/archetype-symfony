<?php

namespace Tests\Runroom\StaticPageBundle\MotherObject;

use Runroom\StaticPageBundle\Entity\StaticPage;
use Tests\Runroom\BaseBundle\MotherObject\EntityMetaInformationMotherObject;

class StaticPageMotherObject
{
    const ID = 1;
    const TITLE = 'title';
    const CONTENT = 'content';
    const LOCATION = 'none';
    const SLUG = 'slug';
    const PUBLISH = true;

    public static function create()
    {
        $staticPage = new StaticPage();

        $staticPage->setId(self::ID);
        $staticPage->setLocation(self::LOCATION);
        $staticPage->translate()->setTitle(self::TITLE);
        $staticPage->translate()->setContent(self::CONTENT);
        $staticPage->translate()->setSlug(self::SLUG);
        $staticPage->setPublish(self::PUBLISH);
        $staticPage->setMetaInformation(EntityMetaInformationMotherObject::create());

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
