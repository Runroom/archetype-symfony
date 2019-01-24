<?php

namespace Runroom\CookiesBundle\ViewModel;

use Runroom\BaseBundle\ViewModel\CookiesViewModelInterface;

class CookiesViewModel implements CookiesViewModelInterface
{
    protected $performanceCookies = [];
    protected $targetingCookies = [];
    protected $isInternalIp;
    protected $performanceIsAccepted;
    protected $targetingIsAccepted;

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

    public function setPerformanceIsAccepted(bool $performanceIsAccepted): void
    {
        $this->performanceIsAccepted = $performanceIsAccepted;
    }

    public function getPerformanceIsAccepted(): ?bool
    {
        return $this->performanceIsAccepted;
    }

    public function setTargetingIsAccepted(bool $targetingIsAccepted): void
    {
        $this->targetingIsAccepted = $targetingIsAccepted;
    }

    public function getTargetingIsAccepted(): ?bool
    {
        return $this->targetingIsAccepted;
    }
}
