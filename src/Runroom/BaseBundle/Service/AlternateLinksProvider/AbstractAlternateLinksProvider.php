<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractAlternateLinksProvider implements AlternateLinksProviderInterface
{
    protected static $routes = [];
    protected $router;
    protected $requestStack;
    protected $locales;
    protected $xdefaultLocale;

    public function __construct(UrlGeneratorInterface $router, RequestStack $requestStack, array $locales, ?string $xdefaultLocale)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->locales = $locales;
        $this->xdefaultLocale = $xdefaultLocale;
    }

    public function providesAlternateLinks(string $route): bool
    {
        return \in_array($route, static::$routes);
    }

    public function findAlternateLinksFor(string $route, $model): array
    {
        $alternateLinks = [];

        try {
            foreach ($this->locales as $locale) {
                $alternateLinks[$locale] = $this->router->generate(
                    $route . '.' . $locale,
                    \array_merge(
                        $this->getRouteParameters($model, $locale),
                        $this->getQueryParameters()
                    ),
                    UrlGeneratorInterface::ABSOLUTE_URL
                );
            }
        } catch (\Exception $e) {
        }

        if ($this->xdefaultLocale && array_key_exists($this->xdefaultLocale, $alternateLinks)) {
            $alternateLinks['x-default'] = $alternateLinks[$this->xdefaultLocale];
        }

        return $alternateLinks;
    }

    abstract public function getRouteParameters($model, string $locale): array;

    private function getQueryParameters(): array
    {
        return $this->requestStack->getCurrentRequest()->query->all();
    }
}
