<?php

namespace Tests\Archetype\DemoBundle\Fixtures;

use Archetype\DemoBundle\Entity\Category;

class CategoryFixture
{
    const NAME = 'name';

    public static function create(): Category
    {
        $category = new Category();
        $category->translate()->setName(self::NAME);

        return $category;
    }
}
