<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

interface AlternateLinksProviderInterface
{
    public function providesAlternateLinks($base_route);

    public function findAlternateLinksFor($base_route, $model);
}
