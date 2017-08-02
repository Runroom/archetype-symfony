<?php

namespace Sonata\AdminBundle\Tests;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\DependencyInjection\Compiler\AlternateLinksPass;
use Runroom\BaseBundle\DependencyInjection\Compiler\MetaInformationPass;
use Runroom\BaseBundle\RunroomBaseBundle;

class RunroomBaseBundleTest extends TestCase
{
    /**
     * @test
     */
    public function itBuildsTheBundle()
    {
        $containerBuilder = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');

        $containerBuilder
            ->addCompilerPass(Argument::type(MetaInformationPass::class))
            ->shouldBeCalled();

        $containerBuilder
            ->addCompilerPass(Argument::type(AlternateLinksPass::class))
            ->shouldBeCalled();

        $bundle = new RunroomBaseBundle();
        $bundle->build($containerBuilder->reveal());
    }
}
