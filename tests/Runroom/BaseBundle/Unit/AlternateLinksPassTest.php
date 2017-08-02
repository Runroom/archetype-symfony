<?php

namespace Tests\Symfony\Component\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\DependencyInjection\Compiler\AlternateLinksPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlternateLinksPassTest extends TestCase
{
    /**
     * @test
     */
    public function itBindsProvidersToTheAlternateLinksServiceProcess()
    {
        $container = new ContainerBuilder();

        $container->register(
            'runroom.base.service.alternate_links',
            'Runroom\BaseBundle\Service\AlternateLinksService'
        );

        $container->register('foo')->addTag('base.alternate_links');

        $pass = new AlternateLinksPass();
        $pass->process($container);

        $definition = $container->getDefinition('runroom.base.service.alternate_links');
        $methodCalls = $definition->getMethodCalls();

        $this->assertCount(1, $methodCalls);
        $this->assertSame('addProvider', $methodCalls[0][0]);
    }
}
