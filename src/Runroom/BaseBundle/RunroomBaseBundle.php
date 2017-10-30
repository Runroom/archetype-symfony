<?php

namespace Runroom\BaseBundle;

use Runroom\BaseBundle\DependencyInjection\Compiler\AlternateLinksPass;
use Runroom\BaseBundle\DependencyInjection\Compiler\MetaInformationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RunroomBaseBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new MetaInformationPass());
        $container->addCompilerPass(new AlternateLinksPass());
    }
}
