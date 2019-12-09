<?php

namespace Tests\Runroom\BaseBundle\Fixtures;

use Runroom\BaseBundle\Entity\MetaInformation;

class MetaInformationFixture
{
    public const ID = 1;
    public const ROUTE = 'route';
    public const ROUTE_NAME = 'route name';
    public const IMAGE = null;
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';

    public static function create(): MetaInformation
    {
        $metaInformation = new MetaInformation();

        $metaInformation->setId(self::ID);
        $metaInformation->setRoute(self::ROUTE);
        $metaInformation->setRouteName(self::ROUTE_NAME);
        $metaInformation->setImage(self::IMAGE);
        $metaInformation->translate()->setTitle(self::TITLE);
        $metaInformation->translate()->setDescription(self::DESCRIPTION);

        return $metaInformation;
    }
}
