<?php

namespace Runroom\BaseBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AlternateLinksPass implements CompilerPassInterface
{
    const SERVICE = 'runroom.base.service.alternate_links';
    const TAG = 'base.alternate_links';

    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(self::SERVICE);
        $tagged_services = $container->findTaggedServiceIds(self::TAG);

        foreach ($tagged_services as $id => $service) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
