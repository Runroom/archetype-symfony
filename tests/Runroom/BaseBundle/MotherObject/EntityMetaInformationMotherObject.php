<?php

namespace Tests\Runroom\BaseBundle\MotherObject;

use Runroom\BaseBundle\Entity\EntityMetaInformation;

class EntityMetaInformationMotherObject
{
    const ID = 1;
    const TITLE = 'title';
    const DESCRIPTION = 'description';

    public static function createWithMetas()
    {
        $metaInformation = new EntityMetaInformation();

        $metaInformation->setTitle('meta_title');
        $metaInformation->setDescription('meta_description');

        return $metaInformation;
    }

    public static function createFilled()
    {
        $metaInformation = new EntityMetaInformation();

        $metaInformation->setId(self::ID);
        $metaInformation->setTitle(self::TITLE);
        $metaInformation->setDescription(self::DESCRIPTION);

        return $metaInformation;
    }
}
