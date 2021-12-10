<?php

declare(strict_types=1);

use App\Story\ContentStory;
use Symfony\Component\Dotenv\Dotenv;
use Zenstruck\Foundry\Test\TestState;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

TestState::addGlobalState(function () {
    ContentStory::load();
});
