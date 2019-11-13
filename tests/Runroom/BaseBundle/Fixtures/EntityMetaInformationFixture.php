<?php

namespace Tests\Runroom\BaseBundle\Fixtures;

use Runroom\BaseBundle\Entity\EntityMetaInformation;

class EntityMetaInformationFixture
{
    const ID = 1;
    const TITLE = 'title';
    const DESCRIPTION = 'description';

    public static function create(): EntityMetaInformation
    {
        $metaInformation = new EntityMetaInformation();

        $metaInformation->setId(self::ID);
        $metaInformation->translate()->setTitle(self::TITLE);
        $metaInformation->translate()->setDescription(self::DESCRIPTION);

        return $metaInformation;
    }
}
