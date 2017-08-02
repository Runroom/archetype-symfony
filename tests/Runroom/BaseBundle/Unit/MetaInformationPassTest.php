<?php

namespace Tests\Symfony\Component\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\DependencyInjection\Compiler\MetaInformationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MetaInformationPassTest extends TestCase
{
    /**
     * @test
     */
    public function itBindsProvidersToTheMetaInformationServiceProcess()
    {
        $container = new ContainerBuilder();

        $container->register(
            'runroom.base.service.meta_information',
            'Runroom\BaseBundle\Service\MetaInformationService'
        );

        $container->register('foo')->addTag('base.meta_information');

        $pass = new MetaInformationPass();
        $pass->process($container);

        $definition = $container->getDefinition('runroom.base.service.meta_information');
        $methodCalls = $definition->getMethodCalls();

        $this->assertCount(1, $methodCalls);
        $this->assertSame('addProvider', $methodCalls[0][0]);
    }
}
