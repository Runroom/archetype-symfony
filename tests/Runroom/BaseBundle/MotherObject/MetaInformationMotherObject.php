<?php

namespace Tests\Runroom\BaseBundle\MotherObject;

use Runroom\BaseBundle\Entity\MetaInformation;

class MetaInformationMotherObject
{
    const ID = 1;
    const ROUTE = 'route';
    const ROUTE_NAME = 'route name';
    const IMAGE = null;
    const TITLE = 'title';
    const DESCRIPTION = 'description';

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
