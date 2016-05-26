<?php

namespace Runroom\DemoBundle\ViewModel;

class DemoViewModel
{
    protected $demos;

    public function getDemos()
    {
        return $this->demos;
    }

    public function setDemos(array $demos)
    {
        $this->demos = $demos;
    }
}
