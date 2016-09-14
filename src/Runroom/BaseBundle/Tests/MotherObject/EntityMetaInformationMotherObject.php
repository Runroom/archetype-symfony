<?php

namespace Runroom\BaseBundle\Tests\MotherObject;

use Runroom\BaseBundle\Entity\EntityMetaInformation;

class EntityMetaInformationMotherObject
{
    const ID = 1;
    const TITLE = 'title';
    const DESCRIPTION = 'description';

    public static function createWithMetas()
    {
        $entity_meta_information = new EntityMetaInformation();

        $entity_meta_information->setTitle('meta_title');
        $entity_meta_information->setDescription('meta_description');

        return $entity_meta_information;
    }

    public static function createFilled()
    {
        $entity_meta_information = new EntityMetaInformation();

        $entity_meta_information->setId(self::ID);
        $entity_meta_information->setTitle(self::TITLE);
        $entity_meta_information->setDescription(self::DESCRIPTION);

        return $entity_meta_information;
    }
}
