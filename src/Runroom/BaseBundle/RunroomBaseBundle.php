<?php

namespace Runroom\BaseBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Runroom\BaseBundle\DependencyInjection\Compiler\MetaInformationPass;
use Runroom\BaseBundle\DependencyInjection\Compiler\AlternateLinksPass;

class RunroomBaseBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MetaInformationPass());
        $container->addCompilerPass(new AlternateLinksPass());
    }
}
