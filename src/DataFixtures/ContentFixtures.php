<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Story\ContentStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ContentFixtures extends Fixture
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        ContentStory::load();
        $manager->flush();
    }
}
