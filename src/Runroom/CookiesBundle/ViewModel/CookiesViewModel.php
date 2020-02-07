<?php

namespace Runroom\CookiesBundle\ViewModel;

class CookiesViewModel
{
    protected $performanceCookies = [];
    protected $targetingCookies = [];

    public function setPerformanceCookies(array $performanceCookies): self
    {
        $this->performanceCookies = $performanceCookies;

        return $this;
    }

    public function getPerformanceCookies(): ?array
    {
        return $this->performanceCookies;
    }

    public function setTargetingCookies(array $targetingCookies): self
    {
        $this->targetingCookies = $targetingCookies;

        return $this;
    }

    public function getTargetingCookies(): ?array
    {
        return $this->targetingCookies;
    }
}
