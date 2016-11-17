<?php

namespace Archetype\DemoBundle\Tests\MotherObjects;

use Application\Sonata\MediaBundle\Entity\Media;
use Archetype\DemoBundle\Entity\Demo;

class DemoMotherObject
{
    const NAME = 'name';

    public static function create()
    {
        $picture = new Media();

        $demo = new Demo();
        $demo->setName(self::NAME);
        $demo->setPicture($picture);

        return $demo;
    }
}
