<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

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

        try {
            foreach ($this->getAvailableLocales($provider, $model) as $locale) {
                $alternateLinks[$locale] = $this->urlGenerator->generate(
                    $route . '.' . $locale,
                    $provider->getParameters($model, $locale) ?? $routeParameters,
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
            }
        } catch (RouteNotFoundException $e) {
        }

        return $alternateLinks;
    }

    protected function getAvailableLocales(AlternateLinksProviderInterface $provider, $model): array
    {
        return $provider->getAvailableLocales($model) ?? $this->locales;
    }
}
