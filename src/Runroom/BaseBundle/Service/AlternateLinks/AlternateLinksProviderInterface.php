<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

interface AlternateLinksProviderInterface
{
    public function providesAlternateLinks(string $route): bool;

    public function getRouteParameters($model, string $locale): array;

    public function getQueryParameters($model, string $locale): array;
}
