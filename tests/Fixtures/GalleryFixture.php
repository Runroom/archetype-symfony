<?php

namespace Tests\Fixtures;

use App\Entity\Gallery;

class GalleryFixture
{
    /** @var int */
    public const ID = 1;

    public static function createFilled(): Gallery
    {
        $gallery = new Gallery();

        $gallery->setId(self::ID);

        return $gallery;
    }
}
