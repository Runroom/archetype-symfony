<?php

namespace Runroom\EntitiesBundle\Tests\Unit;

use Runroom\EntitiesBundle\Tests\MotherObject\GalleryImageMotherObject;

class GalleryImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $gallery_image = GalleryImageMotherObject::createFilled();

        $this->assertEquals(GalleryImageMotherObject::ID, $gallery_image->getId());
        $this->assertEquals(GalleryImageMotherObject::IMAGE, $gallery_image->getImage());
        $this->assertEquals(GalleryImageMotherObject::GALLERY, $gallery_image->getGallery());
    }
}
