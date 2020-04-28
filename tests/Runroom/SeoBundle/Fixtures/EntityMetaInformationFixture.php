<?php

namespace Tests\Runroom\SeoBundle\Fixtures;

use Runroom\SeoBundle\Entity\EntityMetaInformation;

class EntityMetaInformationFixture
{
    public const ID = 1;
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';

    public static function create(): EntityMetaInformation
    {
        $metaInformation = new EntityMetaInformation();

        $metaInformation->setId(self::ID);
        $metaInformation->translate()->setTitle(self::TITLE);
        $metaInformation->translate()->setDescription(self::DESCRIPTION);

        return $metaInformation;
    }
}
