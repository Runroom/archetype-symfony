<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Story\ContentStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ContentStory::load();
        $manager->flush();
    }
}
