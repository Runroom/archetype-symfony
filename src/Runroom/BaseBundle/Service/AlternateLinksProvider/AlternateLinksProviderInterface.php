<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

interface AlternateLinksProviderInterface
{
    public function providesAlternateLinks($route);

    public function findAlternateLinksFor($route, $model);
}
