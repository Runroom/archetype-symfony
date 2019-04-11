<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Runroom\BaseBundle\Service\AlternateLinks\AbstractAlternateLinksProvider;
use Runroom\BaseBundle\Service\AlternateLinks\AlternateLinksBuilder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AlternateLinksBuilderTest extends TestCase
{
    protected $urlGenerator;
    protected $locales;
    protected $provider;
    protected $builder;

    protected function setUp(): void
    {
        $this->urlGenerator = $this->prophesize(UrlGeneratorInterface::class);
        $this->locales = ['es', 'en'];

        $this->provider = new DummyAlternateLinksProvider();
        $this->builder = new AlternateLinksBuilder(
            $this->urlGenerator->reveal(),
            $this->locales
        );
    }

    /**
     * @test
     */
    public function itDoesNotProvideAnyAlternateLinks()
    {
        $this->assertFalse($this->provider->providesAlternateLinks('default'));
    }

    /**
     * @test
     */
    public function itFindsAlternateLinksForRoute()
    {
        $route = 'dummy_route';

        foreach ($this->locales as $locale) {
            $this->urlGenerator->generate($route . '.' . $locale, [
                'dummy_param' => 'dummy_value',
                'dummy_query' => 'dummy_value',
            ], UrlGeneratorInterface::ABSOLUTE_URL)->willReturn($locale);
        }

        $alternateLinks = $this->builder->build($this->provider, $route, 'model');

        foreach ($this->locales as $locale) {
            $this->assertContains($locale, $alternateLinks);
        }
    }

    /**
     * @test
     */
    public function itReturnsEmptyAlternateLinksIfRouteDoesNotExist()
    {
        $this->urlGenerator->generate(Argument::any())->willThrow('Exception');

        $this->assertEmpty($this->builder->build($this->provider, 'missing_route', 'model'));
    }
}

class DummyAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getRouteParameters($model, string $route): array
    {
        return ['dummy_param' => 'dummy_value'];
    }

    public function getQueryParameters($model, string $route): array
    {
        return ['dummy_query' => 'dummy_value'];
    }

    protected function getRoutes(): array
    {
        return ['dummy_route'];
    }
}
