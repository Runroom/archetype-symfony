<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

interface MetaInformationProviderInterface
{
    public function providesMetas($meta_route);

    public function findMetasFor($meta_route, $model);
}
