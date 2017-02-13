<?php

namespace Tests\Symfony\Component\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\DependencyInjection\Compiler\AlternateLinksPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlternateLinksPassTest extends TestCase
{
    const METHOD_CALLS = 1;

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

        $container
            ->register('foo')
            ->addTag('base.alternate_links');

        $pass = new AlternateLinksPass();
        $pass->process($container);

        $definition = $container->getDefinition('runroom.base.service.alternate_links');
        $method_calls = $definition->getMethodCalls();

        $this->assertCount(self::METHOD_CALLS, $method_calls);
        $this->assertEquals('addProvider', $method_calls[0][0]);
    }
}
