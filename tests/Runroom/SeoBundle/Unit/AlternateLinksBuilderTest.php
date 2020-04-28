<?php

namespace Tests\Runroom\SeoBundle\Unit;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Runroom\SeoBundle\AlternateLinks\AbstractAlternateLinksProvider;
use Runroom\SeoBundle\AlternateLinks\AlternateLinksBuilder;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AlternateLinksBuilderTest extends TestCase
{
    use ProphecyTrait;

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

        $alternateLinks = $this->builder->build($this->provider, 'model', $route);

        foreach ($this->locales as $locale) {
            $this->assertContains($locale, $alternateLinks);
        }
    }

    /**
     * @test
     */
    public function itReturnsEmptyAlternateLinksIfRouteDoesNotExist()
    {
        $this->urlGenerator->generate(Argument::cetera())->willThrow(RouteNotFoundException::class);

        $this->assertEmpty($this->builder->build($this->provider, 'model', 'missing_route'));
    }
}

class DummyAlternateLinksProvider extends AbstractAlternateLinksProvider
{
    public function getParameters($model, string $route): ?array
    {
        return [
            'dummy_param' => 'dummy_value',
            'dummy_query' => 'dummy_value',
        ];
    }

    protected function getRoutes(): array
    {
        return ['dummy_route'];
    }
}
