<?php

declare(strict_types=1);

namespace Tests;

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

require \dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(\dirname(__DIR__) . '/.env');

$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'test', (bool) ($_SERVER['APP_DEBUG'] ?? false));

(new Filesystem())->remove([$kernel->getCacheDir()]);
