<?php

namespace Runroom\BaseBundle\ViewModel;

interface CookiesViewModelInterface
{
    public function setPerformanceCookies(array $performanceCookies): void;

    public function getPerformanceCookies(): ?array;

    public function setTargetingCookies(array $targetingCookies): void;

    public function getTargetingCookies(): ?array;

    public function setPerformanceIsAccepted(bool $performanceIsAccepted): void;

    public function getPerformanceIsAccepted(): ?bool;

    public function setTargetingIsAccepted(bool $targetingIsAccepted): void;

    public function getTargetingIsAccepted(): ?bool;
}
