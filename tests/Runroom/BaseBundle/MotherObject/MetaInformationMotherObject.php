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

    public static function create(string $title, string $description): MetaInformation
    {
        $metaInformation = new MetaInformation();

        $metaInformation->setTitle($title);
        $metaInformation->setDescription($description);

        return $metaInformation;
    }

    public static function createFilled(): MetaInformation
    {
        $metaInformation = new MetaInformation();

        $metaInformation->setId(self::ID);
        $metaInformation->setRoute(self::ROUTE);
        $metaInformation->setRouteName(self::ROUTE_NAME);
        $metaInformation->setImage(self::IMAGE);
        $metaInformation->setTitle(self::TITLE);
        $metaInformation->setDescription(self::DESCRIPTION);

        return $metaInformation;
    }
}
