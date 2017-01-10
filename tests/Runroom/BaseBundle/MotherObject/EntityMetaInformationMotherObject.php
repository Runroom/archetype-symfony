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
        $meta_information = new EntityMetaInformation();

        $meta_information->setTitle('meta_title');
        $meta_information->setDescription('meta_description');

        return $meta_information;
    }

    public static function createFilled()
    {
        $meta_information = new EntityMetaInformation();

        $meta_information->setId(self::ID);
        $meta_information->setTitle(self::TITLE);
        $meta_information->setDescription(self::DESCRIPTION);

        return $meta_information;
    }
}
