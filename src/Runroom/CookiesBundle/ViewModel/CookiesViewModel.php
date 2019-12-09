<?php

namespace Runroom\CookiesBundle\ViewModel;

class CookiesViewModel
{
    protected $performanceCookies = [];
    protected $targetingCookies = [];

    public function setPerformanceCookies(array $performanceCookies): void
    {
        $this->performanceCookies = $performanceCookies;
    }

    public function getPerformanceCookies(): ?array
    {
        return $this->performanceCookies;
    }

    public function setTargetingCookies(array $targetingCookies): void
    {
        $this->targetingCookies = $targetingCookies;
    }

    public function getTargetingCookies(): ?array
    {
        return $this->targetingCookies;
    }
}
