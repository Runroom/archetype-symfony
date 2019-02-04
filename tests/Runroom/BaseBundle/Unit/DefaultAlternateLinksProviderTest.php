<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\Service\AlternateLinks\DefaultAlternateLinksProvider;

class DefaultAlternateLinksProviderTest extends TestCase
{
    protected function setUp()
    {
        $this->provider = new DefaultAlternateLinksProvider();
    }

    /**
     * @test
     */
    public function itProvidesMetasForAnyRoute()
    {
        foreach (['default', 'home'] as $route) {
            $this->assertTrue($this->provider->providesAlternateLinks($route));
        }
    }

    /**
     * @test
     */
    public function itDoesNotDefineRouteParameters()
    {
        $this->assertEmpty($this->provider->getRouteParameters(new \stdClass(), 'es'));
    }

    /**
     * @test
     */
    public function itDoesNotDefineQueryParameters()
    {
        $this->assertEmpty($this->provider->getQueryParameters(new \stdClass(), 'es'));
    }

    /**
     * @test
     */
    public function itDoesNotDefineAssociatedRoutes()
    {
        $method = new \ReflectionMethod($this->provider, 'getRoutes');
        $method->setAccessible(true);

        $this->assertEmpty($method->invoke($this->provider));
    }
}
