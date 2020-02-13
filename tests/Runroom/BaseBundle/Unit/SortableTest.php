<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Runroom\BaseBundle\Fixtures\SortableEntity;

class SortableTest extends TestCase
{
    protected const POSITION = 42;

    /**
     * @test
     */
    public function itSetsAndGetsPosition()
    {
        $sortable = new SortableEntity();

        $sortable = $sortable->setPosition(self::POSITION);

        $this->assertEquals(self::POSITION, $sortable->getPosition());
    }
}
