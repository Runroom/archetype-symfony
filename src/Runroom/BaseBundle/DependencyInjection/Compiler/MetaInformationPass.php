<?php

namespace Runroom\BaseBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MetaInformationPass implements CompilerPassInterface
{
    const SERVICE = 'runroom.base.service.meta_information';
    const TAG = 'base.meta_information';

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition(self::SERVICE);
        $taggetServices = $container->findTaggedServiceIds(self::TAG);

        foreach ($taggetServices as $id => $service) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
