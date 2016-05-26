<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->exclude([
        'cache',
        'ansible',
        'node_modules',
    ])
    ->notName('SymfonyRequirements.php')
    ->notName('check.php')
    ->notName('config.php')
;

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->fixers([
        'concat_with_spaces',
        'ordered_use',
        'short_array_syntax',
    ])
    ->finder($finder)
;
