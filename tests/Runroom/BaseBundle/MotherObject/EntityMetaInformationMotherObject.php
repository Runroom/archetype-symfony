<?php

namespace Tests\Runroom\BaseBundle\MotherObject;

use Runroom\BaseBundle\Entity\EntityMetaInformation;

class EntityMetaInformationMotherObject
{
    const ID = 1;
    const TITLE = 'title';
    const DESCRIPTION = 'description';

    public static function createWithMetas(): EntityMetaInformation
    {
        $metaInformation = new EntityMetaInformation();

        $metaInformation->translate()->setTitle('meta_title');
        $metaInformation->translate()->setDescription('meta_description');

        return $metaInformation;
    }

    public static function createFilled(): EntityMetaInformation
    {
        $metaInformation = new EntityMetaInformation();

        $metaInformation->setId(self::ID);
        $metaInformation->translate()->setTitle(self::TITLE);
        $metaInformation->translate()->setDescription(self::DESCRIPTION);

        return $metaInformation;
    }
}
