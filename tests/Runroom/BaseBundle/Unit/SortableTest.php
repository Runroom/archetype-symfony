<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;

class SortableTest extends TestCase
{
    const POSITION = 42;

    /**
     * @test
     */
    public function itSetsAndGetsPosition()
    {
        $sortable = $this->getMockForTrait('Runroom\BaseBundle\Behaviors\Sortable');

        $sortable = $sortable->setPosition(self::POSITION);

        $this->assertEquals(self::POSITION, $sortable->getPosition());
    }
}
