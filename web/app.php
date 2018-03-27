<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../app/autoload.php';

$kernel = new AppKernel('prod', false);

// If you want to use HTTP Cache, just uncomment the following PHP lines
// $kernel = new AppCache($kernel);
// Request::enableHttpMethodParameterOverride();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
