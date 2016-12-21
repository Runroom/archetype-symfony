<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../app/autoload.php';

Debug::enable();

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
