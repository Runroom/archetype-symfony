<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Behaviors\Sortable;

class SortableTest extends TestCase
{
    protected const POSITION = 42;

    /**
     * @test
     */
    public function itSetsAndGetsPosition()
    {
        $sortable = $this->getMockForTrait(Sortable::class);

        $sortable = $sortable->setPosition(self::POSITION);

        $this->assertEquals(self::POSITION, $sortable->getPosition());
    }
}
