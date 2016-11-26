<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

interface MetaInformationProviderInterface
{
    public function providesMetas($route);

    public function findMetasFor($route, $model);
}
