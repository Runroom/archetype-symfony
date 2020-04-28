<?php

namespace Runroom\SeoBundle\AlternateLinks;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AlternateLinksBuilder
{
    protected $urlGenerator;
    protected $locales;

    public function __construct(UrlGeneratorInterface $urlGenerator, array $locales)
    {
        $this->urlGenerator = $urlGenerator;
        $this->locales = $locales;
    }

    public function build(
        AlternateLinksProviderInterface $provider,
        $model,
        string $route,
        array $routeParameters = []
    ): array {
        $alternateLinks = [];

        foreach ($this->getAvailableLocales($provider, $model) as $locale) {
            try {
                $alternateLinks[$locale] = $this->urlGenerator->generate(
                    $route . '.' . $locale,
                    $provider->getParameters($model, $locale) ?? $routeParameters,
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
            } catch (RouteNotFoundException $e) {
            }
        }

        return $alternateLinks;
    }

    protected function getAvailableLocales(AlternateLinksProviderInterface $provider, $model): array
    {
        return \array_intersect(
            $this->locales,
            $provider->getAvailableLocales($model) ?? $this->locales
        );
    }
}
