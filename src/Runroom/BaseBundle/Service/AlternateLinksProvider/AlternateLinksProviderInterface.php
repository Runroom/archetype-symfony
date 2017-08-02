<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

interface AlternateLinksProviderInterface
{
    public function providesAlternateLinks(string $route): bool;
    public function findAlternateLinksFor(string $route, $model): array;
}
