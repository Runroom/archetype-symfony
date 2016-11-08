<?php

namespace Runroom\BaseBundle\Service\AlternateLinksProvider;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

abstract class AbstractAlternateLinksProvider implements AlternateLinksProviderInterface
{
    protected static $routes = [];
    protected $router;
    protected $locales;

    public function __construct(Router $router, array $locales)
    {
        $this->router = $router;
        $this->locales = $locales;
    }

    public function providesAlternateLinks($base_route)
    {
        return in_array($base_route, static::$routes);
    }

    public function findAlternateLinksFor($base_route, $model)
    {
        $alternate_links = [];

        try {
            foreach ($this->locales as $locale) {
                $alternate_links[$locale] = $this->router->generate(
                    $base_route . '.' . $locale,
                    $this->getRouteParameters($model, $locale)
                );
            }
        } catch (\Exception $e) {
        }

        return $alternate_links;
    }

    abstract public function getRouteParameters($model, $locale);
}
