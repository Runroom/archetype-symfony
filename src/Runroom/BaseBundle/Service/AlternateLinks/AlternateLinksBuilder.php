<?php

namespace Runroom\BaseBundle\Service\AlternateLinks;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AlternateLinksBuilder
{
    protected $router;
    protected $locales;

    public function __construct(UrlGeneratorInterface $router, array $locales)
    {
        $this->router = $router;
        $this->locales = $locales;
    }

    public function build(AlternateLinksProviderInterface $provider, string $route, $model): array
    {
        $alternateLinks = [];

        try {
            foreach ($this->locales as $locale) {
                $alternateLinks[$locale] = $this->router->generate(
                    $route . '.' . $locale,
                    \array_merge(
                        $provider->getRouteParameters($model, $locale),
                        $provider->getQueryParameters($model, $locale)
                    ),
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
            }
        } catch (\Exception $e) {
        }

        return $alternateLinks;
    }
}
