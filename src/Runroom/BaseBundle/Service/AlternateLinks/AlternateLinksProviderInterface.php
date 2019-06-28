<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

interface AlternateLinksProviderInterface
{
    public function providesAlternateLinks(string $route): bool;

    public function getAvailableLocales($model): ?array;

    public function getParameters($model, string $locale): ?array;
}
