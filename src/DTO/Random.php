<?php

namespace App\DTO;

class Random
{
    public $test = 'test';

    public function __construct(string $test)
    {
        $this->test = $test;
    }

    public function getId()
    {
        return 'test';
    }
}
