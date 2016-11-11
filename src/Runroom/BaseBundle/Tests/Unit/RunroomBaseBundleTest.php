<?php

namespace Sonata\AdminBundle\Tests;

use Prophecy\Argument;
use Runroom\BaseBundle\DependencyInjection\Compiler\AlternateLinksPass;
use Runroom\BaseBundle\DependencyInjection\Compiler\MetaInformationPass;
use Runroom\BaseBundle\RunroomBaseBundle;

class RunroomBaseBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itBuildsTheBundle()
    {
        $container_builder = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');

        $container_builder
            ->addCompilerPass(Argument::type(MetaInformationPass::class))
            ->shouldBeCalled();

        $container_builder
            ->addCompilerPass(Argument::type(AlternateLinksPass::class))
            ->shouldBeCalled();

        $bundle = new RunroomBaseBundle();
        $bundle->build($container_builder->reveal());
    }
}
