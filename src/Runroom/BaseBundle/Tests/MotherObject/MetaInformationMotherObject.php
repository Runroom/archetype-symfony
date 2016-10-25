<?php

namespace Runroom\BaseBundle\Tests\MotherObject;

use Runroom\BaseBundle\Entity\MetaInformation;

class MetaInformationMotherObject
{
    const ID = 'id';
    const ROUTE = 'route';
    const ROUTE_NAME = 'route name';
    const IMAGE = null;
    const TITLE = 'title';
    const DESCRIPTION = 'description';

    public static function create($title, $description)
    {
        $meta_information = new MetaInformation();

        $meta_information->setTitle($title);
        $meta_information->setDescription($description);

        return $meta_information;
    }

    public static function createFilled()
    {
        $meta_information = new MetaInformation();

        $meta_information->setId(self::ID);
        $meta_information->setRoute(self::ROUTE);
        $meta_information->setRouteName(self::ROUTE_NAME);
        $meta_information->setImage(self::IMAGE);
        $meta_information->setTitle(self::TITLE);
        $meta_information->setDescription(self::DESCRIPTION);

        return $meta_information;
    }
}
