<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\Tests\MotherObject\GalleryImageMotherObject;

class GalleryImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itGetsProperties()
    {
        $meta_information = GalleryImageMotherObject::createFilled();

        $this->assertEquals(GalleryImageMotherObject::ID, $meta_information->getId());
        $this->assertEquals(GalleryImageMotherObject::FEATURED, $meta_information->getFeatured());
        $this->assertEquals(GalleryImageMotherObject::POSITION, $meta_information->getPosition());
        $this->assertEquals(GalleryImageMotherObject::IMAGE, $meta_information->getImage());
        $this->assertEquals(GalleryImageMotherObject::GALLERY, $meta_information->getGallery());
    }
}
