<?php

namespace Runroom\DemoBundle\Tests\MotherObjects;

use Runroom\DemoBundle\Entity\Demo;
use Application\Sonata\MediaBundle\Entity\Media;

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